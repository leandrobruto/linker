<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Users extends BaseController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Listando os usuários',
            'users' => $this->userModel->withDeleted(true)->paginate(10),
            'pager' => $this->userModel->pager,
        ];

        return view('Admin/Users/index', $data);
    }

    public function search()
    {
        if (!$this->request->isAjax()) 
        {
            exit('Página não encontrada');
        }

        $users = $this->userModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($users as $user) {
            $data['id'] = $user->id;
            $data['value'] = $user->name;

            $retorno[] = $data;
        }
        
        return $this->response->setJson($retorno);
    }

    public function create()
    {

        $user = new user();

        $data = [
            'title'     => "Criando novo usuário",
            'user' => $user,
        ];

        return view('Admin/Users/criar', $data);
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            
            $user = new user($this->request->getPost());
        
            if ($this->userModel->protect(false)->save($user)) {
                return redirect()->to(site_url("admin/users/show/" . $this->userModel->getInsertID()))
                                ->with('success', "Usuário $user->name cadastrado com sucesso!");
            } else {
                return redirect()->back()->with('errors_model', $this->userModel->errors())
                                        ->with('warning', "Por favor verifique os erros abaixo.")
                                        ->withInput();
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }

    }

    public function show($id = null)
    {
        $user = $this->findUserOr404($id);

        $data = [
            'title'     => "Detalhando o usuário $user->email",
            'user' => $user,
        ];
        
        return view('Admin/Users/show', $data);
    }

    public function edit($id = null)
    {
        $user = $this->findUserOr404($id);

        if ($user->deletado_em != null) {
            return redirect()->back()->with('info', "O usuário $user->name encontra-se excluído. Portanto, não é possível editá-lo.");
        }
        
        $data = [
            'title'     => "Editando o usuário $user->name",
            'user' => $user,
        ];

        return view('Admin/Users/edit', $data);
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
            return redirect()->to(site_url("admin/users/show/$user->id"))
                            ->with('success', "Usuário $user->name atualizado com sucesso!");
        } else {
            return redirect()->back()->with('errors_model', $this->userModel->errors())
                                    ->with('warning', "Por favor, verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    public function delete($id = null)
    {
        $user = $this->findUserOr404($id);

        if ($user->deletado_em != null) {
            return redirect()->back()->with('info', "O usuário $user->name já encontra-se excluído!");
        }

        if ($user->is_admin) {
            return redirect()->back()->with('info', "Não é possível excluir um Usuário <b>Administrador</b>.");
        }

        if ($this->request->getMethod() === 'post') {
            $this->userModel->delete($id);
            return redirect()->to(site_url('admin/users'))
                            ->with('success', "Usuário $user->name excluído com sucesso.");
        }

        $data = [
            'title'     => "Excluindo o usuário $user->name",
            'user' => $user,
        ];

        return view('Admin/Users/excluir', $data);
    }

    public function undelete($id = null)
    {
        $user = $this->findUserOr404($id);
        
        if ($user->deletado_em == null) {
            return redirect()->back()->with('info', "Apenas usuários excluídos podem ser recuperados.");
        }

        if ($this->userModel->desfazerExclusao($id)) {
            return redirect()->back()->with('success', "Exclusão desfeita com sucesso!");
        } else {
            return redirect()->back()->with('errors_model', $this->userModel->errors())
                                    ->with('warning', "Por favor verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    /**
     * @param int $id
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
