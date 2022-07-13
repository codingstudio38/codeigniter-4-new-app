<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title'=>'Home Page'
        ];
        echo view('welcome_message',$data);
    }
}
