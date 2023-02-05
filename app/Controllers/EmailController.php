<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EmailController extends BaseController
{
    public function index()
    {
        $data = [
            'title'=>'Send Email'
        ];
        echo view('user/email',$data);
    }

    public function send(){
        $validtion_msg = $this->validate([
            'Name'=>'required',
            'Email'=>'required|valid_email',
            'Subject'=>'required',
            'Message'=>'required',
        ]);
        if($validtion_msg == false){
            $error =$this->validation->getErrors(); 
            $this->session->setFlashdata('error_msg', $error);
            return redirect('user/sendmail')->withInput();
        } else {
            if($this->isOnline()){
               $name = $this->request->getPost('Name');
               $to = $this->request->getPost('Email');
               $subject = $this->request->getPost('Subject');
               $message = $this->request->getPost('Message');
               $data = [
                'name'   => $name,
                'subject'=> $subject,
                'message'=> $message
               ];
               $email = \Config\Services::email();
 
// for template desigen
               $view = \Config\Services::renderer();
               $new_message = $view->setVar('data', $data)->render('email-template');
               $email->setTo($to);
               $email->setFrom("onlinemessages0001@gmail.com","Online Message");
               $email->setSubject($subject);
               $email->setMessage($new_message);
// for template desigen
               
// for text message
               // $email->setTo($to);
               // $email->setFrom("onlinemessages0001@gmail.com","Online Message");
               // $email->setSubject($subject);
               // $email->setMessage($message);
// for text message


               if($email->send()){
                $response = [
                    'status'=>'success',
                    'message'=>'Email has been successfully sent..'
                ];
                $this->session->setFlashdata('response', $response);
                return redirect('user/sendmail');
               } else {
                $response = [
                    'status'=>'failed',
                    'message'=>'Failed to send email..!!'
                ];
                $this->session->setFlashdata('response', $response);
                return redirect('user/sendmail')->withInput();
               }

            } else {
                $response = [
                    'status'=>'failed',
                    'message'=>'No internet connection..!!'
                ];
                $this->session->setFlashdata('response', $response);
                return redirect('user/sendmail')->withInput();
            }
        }
    }

    public function isOnline($site = "https://www.youtube.com/"){
        if(@fopen($site, "r")){
            return true;
        } else {
            return false;
        }
    }






}
