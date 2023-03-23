<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Profiles;
use App\Models\Logindetails;
use Config\Services;
use CodeIgniter\I18n\Time;

class LoginController extends BaseController
{ 
    private $usersModel = null;
    private $profilesModel = null;
    private $logindetailsModel = null;
    private $login_user = null;
    public function __construct()
    {
        $this->usersModel = new Users();
        $this->profilesModel = new Profiles();
        $this->logindetailsModel = new Logindetails();
        $this->login_user = session()->get('user');
    }
    public function register()
    {
        $data = [
            'title' => 'Rgister Page'
        ];
        echo view('register', $data);
    }
    public function create() 
    {
        $validtion_msg = $this->validate(
            [
                'Name' => 'required',
                'Email_Id' => 'required|valid_email|min_length[6]|is_unique[users.email]',
                'Phone_No' => 'required|max_length[10]|is_unique[users.phone]',
                'Password' => 'required|min_length[8]',
                'Confirm_Password' => 'required|min_length[8]|matches[Password]'
            ],
            [
                'Name' => [
                    "required" => "Name required.",
                ],
                'Email_Id' => [
                    "required" => "Email required.",
                    "valid_email" => "The email must be a valid email address.",
                    "min_length" => "The email must be a greater than 6 characters."
                ],
                'Phone_No' => [
                    "required" => "Email required.",
                    "max_length" => "The phone no must be a less than 10 digit.",
                    "is_unique" => "The phone no already taken. Try different.."
                ],
                'Password' => [
                    "required" => "Password required.",
                    "min_length" => "The password must be a greater than 8 characters."
                ],
                'Confirm_Password' => [
                    "required" => "Password required.",
                    "min_length" => "The confirm password must be a greater than 8 characters.",
                    "matches" => "The confirm password not matching with password.",
                ],
            ]
        );
        if ($validtion_msg == false) {
            $error = $this->validation->getErrors();
            $this->session->setFlashdata('error_msg', $error);
            return redirect('register')->withInput();
        } else {
            $Auth_data = [
                'name' => $this->request->getPost('Name'),
                'email' => $this->request->getPost('Email_Id'),
                'phone' => $this->request->getPost('Phone_No'),
                'isloggedin' => 'false',
                'password' => password_hash($this->request->getPost('Confirm_Password'), PASSWORD_DEFAULT),
            ];
            $user = $this->usersModel->save($Auth_data);
            if (!($user)) {
                $this->session->setFlashdata('errorsMsg', 'Failed to upload user data..');
                return redirect('register');
            } else {
                $data = [
                    'user_id' => $this->usersModel->insertID(),
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'country' => null,
                    'thumbnail' => null,
                ]; 
                $result = $this->profilesModel->save($data);
                if ($result) {
                    $this->session->setFlashdata('successMsg', 'User Account Create Successfully. Please Login..');
                    return redirect()->to('register');
                } else {
                    $this->session->setFlashdata('errorsMsg', 'Failed to upload profile data..');
                    return redirect('register');
                }
            }
        }
    }

    public function login()
    {
        //1- app\Libraries -> composer init
        //2- composer require google/apiclient:^2.12.1
        // facebook
        //1- composer require facebook/graph-sdk
        require APPPATH . "Libraries/vendor/autoload.php";
        $code = "";

        $googleuser = array();
        $loginbutton = "";
        session()->remove("access_token");
        session()->remove("fb_access_token");


        $google_client = new \Google_Client();
        $google_client->setClientId("405380673874-cbp1ep7r2otbtrt75cu4chs4ug9hk6e4.apps.googleusercontent.com");
        $google_client->setClientSecret("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");
        $google_client->setRedirectUri(base_url() . '/login?login_type=google');
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if (!$this->session->get("access_token")) {
            $loginbutton = $google_client->createAuthUrl();
        }


        if (isset($_GET['login_type']) && $_GET['login_type'] == "google") {
            if ($this->request->getVAr('code')) {
                $code = $this->request->getVAr('code');
                $token = $google_client->fetchAccessTokenWithAuthCode($code);
                if (!isset($token['error'])) {
                    $google_client->setAccessToken($token['access_token']);
                    $this->session->set('access_token', $token['access_token']);
                    $google_service = new \Google_Service_Oauth2($google_client);
                    $googleuser = $google_service->userinfo->get();
                    echo "<pre>";
                    print_r($googleuser);
                    echo "</pre>";
                }
            }
        }


        $facebook_user = array();
        $fbloginbutton = "";


        $facebook = new \Facebook\Facebook(
            array(
                "app_id" => "1589430858170618",
                "app_secret" => "d621b2eb8bbc8d0da6567bbc1a560398",
                "default_graph_version" => "v2.3"
            )
        );
        $fb_helper = $facebook->getRedirectLoginHelper();
        $fbloginbutton = $fb_helper->getLoginUrl("https://localhost/codeIgniter/new-app/login?login_type=fb", array("email"));

        if (isset($_GET['login_type']) && $_GET['login_type'] == "fb") {
            if ($this->request->getVAr('state')) {
                $fb_helper->getPersistentDataHandler()->set("state", $this->request->getVAr('state'));
            }
   
            if ($this->request->getVAr('code')) {
                $code = $this->request->getVAr('code');
                if ($this->session->get("fb_access_token")) {
                    $fb_access_token = $this->session->get("fb_access_token");
                } else {
                    $fb_access_token = $fb_helper->getAccessToken();
                    // echo $fb_access_token;
                    $this->session->set("fb_access_token", $fb_access_token);
                    $facebook->setDefaultAccessToken($fb_access_token);
                }
                $graph_response = $facebook->get('/me?fields=name,email,id,first_name,last_name,link,gender,locale,picture', $fb_access_token);
                $facebook_user = $graph_response->getGraphUser();
                if (isset($facebook_user['id'])) {
                    // https://graph.facebook.com/$facebook_user['id']/picture
                    echo "<pre>";
                    print_r($facebook_user);
                    echo "</pre>";
                }

            }
        }








        $data = [
            'title' => 'User Login',
            'googleuser' => $googleuser,
            'facebook_user' => $facebook_user,
            'loginbutton' => $loginbutton,
            'fbloginbutton' => $fbloginbutton
        ];
        // echo "<pre>";
        // print_r($googleuser);
        // echo "</pre>";
        echo view('user-login', $data);
    }

    public function verify()
    {
        //$agent = $this->request->getUserAgent();
        $email = $this->request->getPost('Email_Id');
        $password = $this->request->getPost('Password');
        $validtion = $this->validate(
            [
                'Email_Id' => 'required|valid_email|min_length[6]',
                'Password' => 'required'
            ],
            [
                'Email_Id' => [
                    "required" => "Email required.",
                    "valid_email" => "The email must be a valid email address.",
                    "min_length" => "The email must be a greater than 6 characters."
                ],
                'Password' => ["required" => "Password required."],
            ]
        );
        if ($validtion == false) {
            $error = $this->validation->getErrors();
            $this->session->setFlashdata('error_msg', $error);
            return redirect('login')->withInput();
        } else {
            $query = $this->usersModel->where(['email' => $email])->get();
            $result = $query->getRow();
            if ($result == NULL) {
                $this->session->setFlashdata('errorsMsg', 'User Id Not Exists..!!');
                return redirect('login');
            } else {
                $varify = password_verify($password, $result->password);
                if ($varify == true) {
                    $dataUser = $this->usersModel->find($result->id);
                    $dataUser['isloggedin'] = "true";
                    $this->usersModel->save($dataUser);
                    $datalog = [
                        'login_id' => $result->id,
                        'logintime' => Time::now('Asia/Kolkata', 'en_US'),
                        'logouttime' => null,
                        'system' => $_SERVER['HTTP_USER_AGENT']
                    ];
                    $this->logindetailsModel->save($datalog);
                    $userData = [
                        'loginTBL_Id' => $this->logindetailsModel->insertID(),
                        'user_Id' => $result->id,
                        'user_name' => $result->name,
                        'user_email' => $result->email,
                        'isLoggedIn' => true
                    ];
                    $this->session->set('user', $userData);
                    $this->session->setFlashdata('successMsg', 'LoggedIn Successfully..!!');
                    return redirect('user');
                } else {
                    $this->session->setFlashdata('errorsMsg', 'LogIn Failed..!!');
                    return redirect('login');
                }
            }
        }
    }

    public function logout()
    {
        $dataLog = $this->logindetailsModel->find($this->login_user['loginTBL_Id']);
        $dataLog['logouttime'] = Time::now('Asia/Kolkata', 'en_US');
        $this->logindetailsModel->save($dataLog);
        $data = $this->usersModel->find($this->login_user['user_Id']);
        $data['isloggedin'] = "false";
        $this->usersModel->save($data);
        $this->session->remove('user');
        $this->session->setFlashdata('successMsg', 'LoggedOut Successfully');
        return redirect('login');
    }



}