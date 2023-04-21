<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Password extends BaseController
{
    public function __construct() 
    {
        $this->userModel = new \App\Models\UserModel();

    }

    public function forget()
    {
        $data = [
            'title' => 'Esqueci a minha senha.',
        ];

        return view('Password/forget', $data);
    }

    public function processForgetPassword()
    {
        if ($this->request->getMethod() === 'post') {
            
            $user = $this->userModel->findByEmail($this->request->getPost('email'));

            if ($user === null || !$user->active) {
                return redirect()->to(site_url('password/forget'))
                        ->with('warning', 'Não encontramos um conta válida com esse email.')
                        ->withInput();
            }

            $user->startPasswordReset();
            
            $this->userModel->save($user);

            $this->sendEmailPasswordRedefinition($user);

            return redirect()->to(site_url('login'))
                            ->with('success', 'Email de redefinição de senha enviado para a sua caixa de entrada.');
    } else {
            /* Não é POST */
            return redirect()->back();

        }
    }

    public function reset($token = null) {
        
        if ($token === null) {
            return redirect()->to(site_url('password/forget'))->with('warning', 'Link inválido ou expirado.');
        }

        $user = $this->userModel->findUserToResetPassword($token);

        if ($user != null) {

            $data = [
                'title' => 'Redefina sua senha.',
                'token' => $token,
            ];

            return view('Password/reset', $data);
        } else {
            return redirect()->to(site_url('password/forget'))->with('warning', 'Link inválido ou expirado.');
        }
    }

    public function processPasswordReset($token = null) {

        if ($token === null) {
            return redirect()->to(site_url('password/forget'))->with('warning', 'Link inválido ou expirado.');
        }

        $user = $this->userModel->findUserToResetPassword($token);

        if ($user != null) {

            $user->fill($this->request->getPost());
            
            if ($this->userModel->save($user)) {

                /**
                 * Setando as colunas 'reset_hash' e 'reset_expires_in' como null ao invocar  o método abaixo
                 * que foi definido na Entidade User.
                 * 
                 * Invalidamos o link antigo que foi enviado para o e-mail de usuário.
                 */
                $user->completePasswordReset();

                /**
                 * Atualizamos novamente o usuário com os novos valores definidos acima.
                 */
                $this->userModel->save($user);

                return redirect()->to(site_url('login'))->with('success', 'Nova senha cadastrada com sucesso!');
                
            } else {
                return redirect()->to(site_url("password/reset/$token"))
                                ->with('errors_model', $this->userModel->errors())
                                ->with('warning', 'Por favor, verifique os erros abaixo.')
                                ->withInput();
            }

        } else {
            return redirect()->to(site_url('password/forget'))->with('warning', 'Link inválido ou expirado.');
        }
    }

    private function sendEmailPasswordRedefinition(object $user) {

        $email = \Config\Services::email();

        $email->setFrom('no-reply@linker.com.br', 'Linker');
        $email->setTo($user->email);

        $email->setSubject('Redefinição de senha.');
        
        $message = view('Password/reset_email', ['token' => $user->reset_token]);

        $email->setMessage($message);

        $email->send();
    }
}
