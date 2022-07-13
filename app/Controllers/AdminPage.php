<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Profiles;
use App\Models\Logindetails;
class AdminPage extends BaseController
{
    private $usersModel=null;
    private $profilesModel=null;
    private $logindetailsModel=null;
    public function __construct(){
        $this->usersModel = new Users();
        $this->profilesModel = new Profiles();
        $this->logindetailsModel = new Logindetails();
    }
    public function index()
    {
       $data = [
            'title'=>'User Dashboard'
        ];
       // echo view('admin/components/slider-menu',$data);
        echo view('user/dashboard',$data);
    }
}
