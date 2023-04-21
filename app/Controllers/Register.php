<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Register extends BaseController
{
    private $userModel;

    public function __construct() {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Criar nova conta',
        ];

        return view('Register/index', $data);
    }

    public function singUp()
    {
        if ($this->request->getMethod() == 'post') {

            $user = new \App\Entities\User($this->request->getPost());

            $user->startActivation();

            if ($this->userModel->insert($user)) {

                $this->sendEmailToActivationAccount($user);
                
                return redirect()->to(site_url('register/activationsent'));

            } else {
                return redirect()->back()->with('errors_model', $this->userModel->errors())
                                        ->with('warning', "Por favor verifique os erros abaixo.")
                                        ->withInput();
            }


        } else {
            return redirect()->back();
        }
    }

    public function activationsent() 
    {
        $data = [
            'title' => 'E-mail de ativação da conta enviado para a sua caixa de entrada.',
        ];

        return view('Register/activation_sent', $data);
    }

    public function activate(string $token) 
    {
        if ($token == null) {
            return redirect()->to(site_url('login'));
        }

        $this->userModel->activateAccountByToken($token);

        return redirect()->to(site_url('login'))->with('success', 'Conta ativada com sucesso.');
    }

    private function sendEmailToActivationAccount(object $user) {

        $email = \Config\Services::email();

        $email->setFrom('no-reply@linker.com.br', 'Linker');
        $email->setTo($user->email);

        $email->setSubject('Ativação de conta.');
        
        $mensagem = view('Register/activation_email', ['user' => $user]);

        $email->setMessage($mensagem);

        $email->send();
    }
}
