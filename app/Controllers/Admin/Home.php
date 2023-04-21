<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home da Área Restrita'
        ];

        return view('Admin/Home/index', $data);
    }
}
