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
    private $usersModel=null;
    private $profilesModel=null;
    private $logindetailsModel=null;
    private $login_user =null;
    public function __construct(){
        $this->usersModel = new Users();
        $this->profilesModel = new Profiles();
        $this->logindetailsModel = new Logindetails();
        $this->login_user = session()->get('user');
    }
    public function register()
    {
        $data = [ 
            'title'=>'Rgister Page'
        ];
        echo view('register',$data);
    }
    public function create()
    {
        $validtion_msg = $this->validate([
            'Name'=>'required',
            'Email_Id'=>'required|valid_email|min_length[6]|is_unique[users.email]',
            'Phone_No'=>'required|max_length[10]|is_unique[users.phone]',
            'Password'=>'required|min_length[8]',
            'Confirm_Password'=>'required|min_length[8]|matches[Password]'
        ],
        [ 
            'Name' =>[ 
                "required" => "Name required.",
            ],
           'Email_Id' =>[ 
                "required" => "Email required.",
                "valid_email" => "The email must be a valid email address.",
                "min_length" => "The email must be a greater than 6 characters."
            ],
           'Phone_No' =>[ 
                "required" => "Email required.",
                "max_length" => "The phone no must be a less than 10 digit.",
                "is_unique" => "The phone no already taken. Try different.."
            ],
           'Password' =>[ 
                "required" => "Password required.",
                "min_length" => "The password must be a greater than 8 characters."
            ],
            'Confirm_Password' =>[ 
                "required" => "Password required.",
                "min_length" => "The confirm password must be a greater than 8 characters.",
                "matches" => "The confirm password not matching with password.",
            ],
        ]);
        if($validtion_msg == false){ 
            $error =$this->validation->getErrors(); 
            $this->session->setFlashdata('error_msg', $error);
            return redirect('register')->withInput();
        } else {
            $Auth_data = [
                'name' => $this->request->getPost('Name'),
                'email' => $this->request->getPost('Email_Id'),
                'phone' => $this->request->getPost('Phone_No'),
                'isloggedin'=>'false',
                'password' => password_hash($this->request->getPost('Confirm_Password'), PASSWORD_DEFAULT),
            ];
            $user = $this->usersModel->save($Auth_data);
            if(!($user)){
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
                if($result){
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
       $data = [
            'title'=>'User Login'
        ];
        echo view('user-login',$data);
    }

    public function verify()
    {
        //$agent = $this->request->getUserAgent();
        $email = $this->request->getPost('Email_Id');
        $password = $this->request->getPost('Password'); 
        $validtion = $this->validate([
            'Email_Id'=>'required|valid_email|min_length[6]',
            'Password'=>'required'
        ],
        [ 
           'Email_Id' =>[ 
                "required" => "Email required.",
                "valid_email" => "The email must be a valid email address.",
                "min_length" => "The email must be a greater than 6 characters."
            ],
           'Password' =>[ "required" => "Password required."],
        ]);
        if($validtion == false){
            $error =$this->validation->getErrors(); 
            $this->session->setFlashdata('error_msg', $error);
            return redirect('login')->withInput();
        } else {
            $query = $this->usersModel->where(['email'=>$email])->get();
            $result = $query->getRow();
            if($result == NULL){
                $this->session->setFlashdata('errorsMsg','User Id Not Exists..!!');
                return redirect('login');
            } else {
                $varify = password_verify($password,$result->password);
                if($varify == true){
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
                        'loginTBL_Id'=>$this->logindetailsModel->insertID(),
                        'user_Id'=>$result->id,
                        'user_name'=>$result->name,
                        'user_email'=>$result->email,
                        'isLoggedIn'=> true
                    ];
                    $this->session->set('user',$userData);
                    $this->session->setFlashdata('successMsg','LoggedIn Successfully..!!');
                    return redirect('user'); 
                } else {
                    $this->session->setFlashdata('errorsMsg','LogIn Failed..!!');
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
        $this->session->setFlashdata('successMsg','LoggedOut Successfully');
        return redirect('login');
    }



}
