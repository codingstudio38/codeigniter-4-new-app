<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Profiles;
use App\Models\Logindetails;
use App\Models\Post;
class PostController extends BaseController
{
    private $usersModel=null;
    private $profilesModel=null;
    private $logindetailsModel=null;
    private $postModel=null;
    private $login_user =null;
    public function __construct(){
        $this->usersModel = new Users();
        $this->profilesModel = new Profiles();
        $this->logindetailsModel = new Logindetails();
        $this->postModel = new Post();
        $this->login_user = session()->get('user');
    }
    public function index()
    {
        $data = [
            'title'=>'Add New Post',
        ];
        echo view('user/addnew',$data);
    }
    public function createPost()
    {
       $files = [];
       $allfiles = array();
        if($this->request->getMethod() == 'post'){
            $files = $this->request->getFiles('photo');
            $des = $this->request->getPost('Description');
            $rules = $this->validate([
                'photo' => 'uploaded[photo.0]|max_size[photo,3072]|ext_in[photo,png,jpg,gif]|is_image[photo]',
            ]);
            if($rules == true){
            foreach($files['photo'] as $img){
                if($img->isValid() && !$img->hasMoved()){
                    $fileName = $this->login_user['user_Id']."-".rand()."-".$img->getSize().".".$img->getClientExtension();
                    if($img->move('uploads/post_file',$fileName)){
                        $allfiles[] = $fileName;
                        $thumb = implode(",", $allfiles);
                    } else {
                        echo "<p>".$img->getErrorString()."</p>";
                    }
                }
            }
            $data = [
                'userId' =>$this->login_user['user_Id'],
                'constant' =>$des,
                'files' => $thumb,
            ];
            $result = $this->postModel->save($data);
            if($result){
            session()->setFlashdata('successMsg', 'Post Successfully Published..'); 
            return redirect('user/addnew');
            }  else {
                session()->setFlashdata('errorsMsg', 'Failed to published..!!'); 
                return redirect('user/addnew');
            }
            } else {
                $error =$this->validation->getErrors(); 
                $this->session->setFlashdata('photoerrors', $error);
                return redirect('user/addnew');
            }
        }
    }

    public function viewpost()
    { 
        $query = $this->postModel->where('userId =',1)->get();
        $alldata = $query->getResultArray();
        $data = [
            'title'=>'User Post',
            'data'=>$alldata,
        ];
        echo view('user/viewPost',$data);
    }

}
