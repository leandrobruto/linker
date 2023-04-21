<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Accounts extends BaseController
{
    private $user;
    private $userModel;
    private $connectionModel;
    
    public function __construct()
    {
        $this->user = service('auth')->getUserLoggedIn();
        $this->userModel = new \App\Models\UserModel();
        $this->connectionModel = new \App\Models\ConnectionModel();
    }

    public function index($username = null)
    {

        $user = $this->findUserByUsernameOr404($username);

        $data = [
            'title' => 'Meu Perfil!',
            'user' => $user,
        ];
        
        return view('Accounts/profile', $data);

    }

    public function edit($username = null)
    {
        $user = $this->findUserByUsernameOr404($username);

        if ($user->deletado_em != null) {
            return redirect()->back()->with('info', "O usuário $user->name encontra-se excluído. Portanto, não é possível editá-lo.");
        }
        
        $data = [
            'title'     => "Editando o usuário $user->name",
            'user' => $user,
        ];

        return view('Accounts/edit', $data);
    }

    public function update($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $user = $this->findUserOr404($id);

            if ($user->deletado_em != null) {
                return redirect()->back()->with('info', "O usuário $user->name encontra-se excluído. Portanto, não é possível editá-lo.");
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }

        $post = $this->request->getPost();
        
        if (empty($post['password'])) {
            $this->userModel->desabilitaValidacaoSenha();
            unset($post['password']);
            unset($post['password_confirmation']);
        }
        unset($post['website']);
        unset($post['bio']);
        unset($post['phoneNumber']);
        $user->fill($post);
        
        if (!$user->hasChanged()) {
            return redirect()->back()->with('info', "Não há dados para atualizar.");
        }
        
        if ($this->userModel->protect(false)->save($user)) {
            return redirect()->to(site_url("accounts/$user->username"))
                            ->with('success', "Usuário " . ucfirst($user->name) . " atualizado com sucesso!");
        } else {
            return redirect()->back()->with('errors_model', $this->userModel->errors())
                                    ->with('warning', "Por favor, verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    public function connect($requested_id = null)
    {
        if ($this->request->getMethod() === 'post') {

            $connection = new \App\Entities\Connection($this->request->getPost());
            $user_requested = $this->findUserOr404($requested_id);

            if ($user_requested->deletado_em != null) {
                return redirect()->back()->with('info', "O usuário $user_requested->name encontra-se excluído. Portanto, não é possível se conectar com o mesmo.");
            }

            if ($this->connectionModel->insert($connection)) {

                // $this->sendConnectionRequest($user_requested);

                // return redirect()->to(site_url("accounts/connectionSent"));
            } else {


                return redirect()->back()
                                ->with('errors_model', $this->connectionModel->errors())
                                ->with('atencao', 'Por favor verifique os erros abaixo')
                                ->withInput();
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    /**
     * @param string username
     * @return objeto user
     */
    private function findUserByUsernameOr404($username = null)
    {
        if (!$username || !$user = $this->userModel->where('username', $username)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário $username");
        }
        
        return $user;
    }

    /**
     * @param int id
     * @return objeto user
     */
    private function findUserOr404($id = null)
    {
        if (!$id || !$user = $this->userModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }
        
        return $user;
    }
}
