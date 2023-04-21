<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        
        $data = [
            'title'     => 'Realize o login',
        ];

        return view('Login/index', $data);
    }

    public function signIn()
    {

        if ($this->request->getMethod('post')) {
            
            $email_username = $this->request->getPost('email-username');
            $password = $this->request->getPost('password');

            $auth = service('auth');
            
            if ($auth->login($email_username, $password)) {
                $user = $auth->getUserLoggedIn();

                if (!$user->is_admin) {

                    return redirect()->to(site_url('/'));
                }
                
                return redirect()->to(site_url('admin/home'))->with('success', "Olá " . ucfirst($user->name) . ", que bom que está de volta!");
            } else {
                return redirect()->back()->with('warning', "Não encontramo suas credenciais de acesso!");
            }

        } else {
            return redirect()->back();
        }
    }

    /**
     * Para que possamos exibir a mensagem de 'Sua sessão expirou.',
     * Após o logout, devemos fazer uma requisição para uma URL, nesse caso a 'mostraMensagemLogout'
     * Pois quando fazemos o Logout, todos os dados da sessão atual, incluindo os flashdata são destruídos.
     * Ou seja, as mensagens nunca serão exibidas.
     * 
     * Poratanto, para conseguirmos exibí-la, basta criarmos o método 'mostraMensagemLogout' que fará o redirect para a Home,
     * Com a mensagem desejada.
     * 
     * E como se trata de um redirect, a mensagem só será exibida uma vez.
     */
    public function logout() {

        service('auth')->logout();
        
        return redirect()->to(site_url('login/showLogoutMessage'));
    }

    public function showLogoutMessage() {

        return redirect()->to(site_url('login'))->with('info', 'Esperamos ver você novamente.');
    }
}
