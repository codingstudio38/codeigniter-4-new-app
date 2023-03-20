<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Profiles;
use App\Models\Logindetails;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
class UserProfilePage extends BaseController
{
    private $usersModel=null;
    private $profilesModel=null;
    private $logindetailsModel=null;
    private $login_user =null;
    public function __construct(){
        $this->usersModel = new Users();
        $this->profilesModel = new Profiles();
        $this->logindetailsModel = new Logindetails();
        $this->countryModel = new Country();
        $this->stateModel = new State();
        $this->cityModel = new City();
        $this->login_user = session()->get('user');
    }
    public function index()
    {
        $builder_user = $this->usersModel
        ->select('users.id as uId,users.name as uname,users.email as uemail,users.phone as uphone,users.updated_at as uupdated_at,profiles.id as pId,profiles.address as paddress,profiles.city as pcity,profiles.state as pstate,profiles.country as pcountry,profiles.thumbnail as pthumbnail')
        ->join('profiles', 'users.id = profiles.user_Id')
        ->find($this->login_user['user_Id']);
        $data = [
            'title'=>'User Dashboard',
            'userdata'=>$builder_user
        ];
        echo view('user/dashboard',$data);
    } 
    public function profile()
    {
        $builderuser = $this->usersModel
        ->select('users.id as uId,users.name as uname,users.email as uemail,users.phone as uphone,users.updated_at as uupdated_at,profiles.id as pId,profiles.address as paddress,profiles.city as pcity,profiles.state as pstate,profiles.country as pcountry,profiles.thumbnail as pthumbnail')
        ->join('profiles', 'users.id = profiles.user_Id')
        ->find($this->login_user['user_Id']);
        $userLogindata = $this->logindetailsModel->find($this->login_user['loginTBL_Id']);
        $data = [
            'title'=>'User Profile',
            'userdata'=>$builderuser,
            'userLogindata'=>$userLogindata
        ];
        
        echo view('user/profile',$data);
    }
    public function updatephoto()
    {
        if($this->request->getMethod() == 'post'){
        $rules = [
            'profileInput' => 'uploaded[profileInput]|max_size[profileInput,2048]|ext_in[profileInput,png,jpg,gif]|is_image[profileInput]',
            ];
            if($this->validate($rules)){    
                $file = $this->request->getFile('profileInput');
                $filename =$this->login_user['user_Id']."$".rand()."$".$file->getSize().".".$file->getClientExtension();
                // $filename =$file->getClientName();
                // $tempfile = $file->getTempName();
                // $ext = $file->getClientExtension();
                // $type = $file->getClientMimeType();
                $file->move('uploads/profile_pic', $filename);
                $editPhoto = $this->profilesModel->find($this->login_user['user_Id']);
                $editPhoto['thumbnail'] = $filename;
                $result = $this->profilesModel->save($editPhoto);
                if($result){
                    session()->setFlashdata('successMsgP', 'Update Successfully..'); 
                    return redirect('user/profile');
                }  else {
                    session()->setFlashdata('errorsMsgP', 'Failed to update..!!'); 
                    return redirect('user/profile');
                }
            } else {
                $error =$this->validation->getErrors(); 
                session()->setFlashdata('errorsP',$error); 
                return redirect('user/profile');
            }
        }
    }
    public function getcountry()
    {
        $Cdata = $this->countryModel->findAll();
        if($Cdata==NULL){
            $data = ['status'=>400,'massage'=>'Failed'];
            return $this->response->setJSON($data);
            exit;
        } else {
            $data = ['country'=>$Cdata,'status'=>200,'massage'=>'Successful'];
            return $this->response->setJSON($data);
            exit;
        }
    }
    public function getstate()
    {
        $countryid = $this->request->getPost('country');
        $query = $this->stateModel->where('countryId =',$countryid)->findAll();
        if($query==NULL){
            $dataS = ['status'=>400,'massage'=>'Failed'];
            return $this->response->setJSON($dataS);
            exit;
        } else {
           $dataS = ['state'=>$query,'status'=>200,'massage'=>'Successful'];
            return $this->response->setJSON($dataS);
            exit;
        }
    }
    public function getcity()
    {
        $stateid = $this->request->getPost('state');
        $query = $this->cityModel->where('state_id =',$stateid)->findAll();
        if($query==NULL){
            $dataC = ['status'=>400,'massage'=>'Failed'];
            return $this->response->setJSON($dataC);
            exit;
        } else {
           $dataC = ['city'=>$query,'status'=>200,'massage'=>'Successful'];
            return $this->response->setJSON($dataC);
            exit;
        }
    }
    public function updateAddress()
    {
        $Country = $this->request->getPost('Country');
        $PState = $this->request->getPost('State');
        $PCity = $this->request->getPost('City');
        $address = $this->request->getPost('address');

        $Country = $this->countryModel->where(['id'=>$Country])->first();
        $State = $this->stateModel->where(['id'=>$PState])->first();
        $City = $this->cityModel->where(['id'=>$PCity])->first();

        $editaddres = $this->profilesModel->find($this->login_user['user_Id']);
        $editaddres['country'] = $Country['name']?$Country['name']:null;
        $editaddres['state'] = $State['statename']?$State['statename']:null;
        $editaddres['city'] = $City['cityName']?$City['cityName']:null;
        $editaddres['address'] = $address?$address:null;
        $result = $this->profilesModel->save($editaddres);
        if($result){
            session()->setFlashdata('successMsg', 'Address Update Successfully..'); 
            return redirect('user/profile');
        }  else {
            session()->setFlashdata('errorsMsg', 'Failed to update..!!'); 
            return redirect('user/profile');
        }
    }
    public function updateName()
    {
        $Name = $this->request->getPost('Name');
        $editname = $this->usersModel->find($this->login_user['user_Id']);
        $editname['name'] = $Name;
        $result = $this->usersModel->save($editname);
        if($result){
            session()->setFlashdata('successMsg', 'Name Update Successfully..'); 
            return redirect('user/profile');
        }  else {
            session()->setFlashdata('errorsMsg', 'Failed to update..!!'); 
            return redirect('user/profile');
        }
    }
    public function updateEmail()
    {
        $email = $this->request->getPost('Email_Id');
        $upid =  $this->login_user['user_Id'];
        $check = $this->usersModel->where('email =',$email)->where('id !=',$upid)->findAll();
        if(!($check == NULL)){
            session()->setFlashdata('errorsMsg', 'Email Id already exist..'); 
            return redirect('user/profile');
        } else {
            $editemail = $this->usersModel->find($upid);
            $editemail['email'] = $email;
            $result = $this->usersModel->save($editemail);
            if($result){
                session()->setFlashdata('successMsg', 'Email Id Update Successfully..'); 
                return redirect('user/profile');
            }  else {
                session()->setFlashdata('errorsMsg', 'Failed to update..!!'); 
                return redirect('user/profile');
            }
        }
    }

    public function updatePhone()
    {
        $phone = $this->request->getPost('Phone_No');
        $upid =  $this->login_user['user_Id'];
        $check = $this->usersModel->where('phone =',$phone)->where('id !=',$upid)->findAll();
        if(!($check == NULL)){
            session()->setFlashdata('errorsMsg', 'Phone No already exist..'); 
            return redirect('user/profile');
        } else {
            $editphone = $this->usersModel->find($upid);
            $editphone['phone'] = $phone;
            $result = $this->usersModel->save($editphone);
            if($result){
                session()->setFlashdata('successMsg', 'Phone No Update Successfully..'); 
                return redirect('user/profile');
            }  else {
                session()->setFlashdata('errorsMsg', 'Failed to update..!!'); 
                return redirect('user/profile');
            }
        }
    }
    public function updatePassword()
    {
        $cpass = $this->request->getPost('Current_Password');
        $npass = $this->request->getPost('New_Password');
        $id = $this->login_user['user_Id'];
        $data = $this->usersModel->find($id);
        $varify = password_verify($cpass,$data['password']);
        $validtion = $this->validate([
            'Current_Password'=>'required|min_length[8]',
            'New_Password'=>'required|min_length[8]'
        ]);
        if($validtion == false){
            $error =$this->validation->getErrors(); 
            $this->session->setFlashdata('errorC', $error);
            return redirect('user/profile');
        } else {
            if($varify == true){
                $data['password'] = password_hash($npass, PASSWORD_DEFAULT);
                $result = $this->usersModel->save($data);
                if($result){
                    session()->setFlashdata('successMsg', 'Password Has Been Changed Successfully..'); 
                    return redirect('user/profile');
                }  else {
                    session()->setFlashdata('errorsMsg', 'Failed to update..!!'); 
                    return redirect('user/profile');
                }

            } else {
                session()->setFlashdata('errorsMsg', 'Current Password Not Match..!!'); 
                return redirect('user/profile');
            }            
        }
    }











}

?>