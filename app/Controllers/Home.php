<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{

    public function index($username = null)
    {        
        $auth = service('auth');

        if ($auth->isLoggedIn()) {
            $data = [
                'title' => 'Seja bem vindo(a)!'
            ];
            
            return view('Home/index', $data);
        } else {

            $data = [
                'title' => 'Realize o login'
            ];
            
            return view('Login/index', $data);
        }
    }
    
}
