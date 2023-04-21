<?php

namespace App\Libraries;

/**
 * @descricao Essa biblioteca / classe cuidará da parte de utenticação da nossa aplicação
 */

class Auth {
    
    private $user;

    public function login(string $email_username, string $password) {

        $userModel = new \App\Models\UserModel();

        $user = $userModel->findByEmailOrUsername($email_username);

        /* Se não encontrar o usuário por e-mail, retorna false */
        if ($user == null) {
            return false;
        }

        /* Se a senha não combinar com o password_hash, retorna false */
        if (!$user->passwordVerify($password)) {
            return false;
        }

        /* Só permitiremos o login de usuários ativos */
        if (!$user->active) {
            return false;
        }

        /* Nesse ponto está tudo certo e podemos logar o usuário na aplicação usando o método abaixo. */
        $this->loginUser($user);

        /* Retornamos true.. Tudo certo */
        return true;
    }


    public function logout() {
        session()->destroy();
    }

    public function getUserLoggedIn() {
        
        /**
         * Não esquecer de compartilhar a instancia com services
         */
        if($this->user === null) {
            $this->user = $this->getUserSession();
        }

        /* Retornamos o usuario que foi definido no início da classe */
        return $this->user;
    }

    /**
     * @descrição: O método só permite ficar logado na aplicação aquele que ainda existir na base que esteja ativo.
     *             Do contrário, será feito o logout do mesmo, caso haja uma mudança na sua conta durante a sua sessão.
     * @uso: No filtro LoginFilter
     * 
     * @return: retorna true se o método getUserLoggedIn() não for null. Ou seja, se o usuário estiver logado.
     */
    public function isLoggedIn() {

        return $this->getUserLoggedIn() != null;
    
    }

    private function getUserSession() {

        if (!session()->has('user_id')) {
            return null;
        }

        /* Instaciamos o model Usuário */
        $userModel = new \App\Models\UserModel();

        /* Recupera o usuário de acordo com a chave da sessão 'user_id' */
        $user = $userModel->find(session()->get('user_id'));

        /* Só retorno o objeto usuário se o mesmo for encontrado e estiver ativo */
        if ($user && $user->active) {
            return $user;
        }

    }

    private function loginUser(object $user) {

        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);

    }
}