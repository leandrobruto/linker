<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Connections extends BaseController
{
    private $userLoggedIn;
    private $userModel;
    private $connectionModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->connectionModel = new \App\Models\ConnectionModel();
    }

    public function index()
    {
        $user = service('auth')->getUserLoggedIn();
        $connections = $this->connectionModel->getConnections($user->id);
        $count = $this->connectionModel->countConnections($user->id);

        $data = [
            'title' => 'Minhas Conexões!',
            'user' => $user,
            'connections' => $connections,
            'count' => $count,
        ];
        
        return view('Connections/index', $data);
    }

}
