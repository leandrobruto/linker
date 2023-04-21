<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Token;

class User extends Entity
{
    protected $dates   = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];

    public function passwordVerify(string $password) {
        return password_verify($password, $this->password_hash);
    }

    public function startPasswordReset() {

        /* Instancia o objeto da classe Token */
        $token = new Token();
        
        /**
         * @descrição: Atribuímos ao objeto User ($this) o atributo 'reset_token' que conterá o token gerado
         *             para que possamos acessá-lo na view 'Password/reset_email'.
         */
        $this->reset_token = $token->getValue();

        /**
         * @descrição: Atribuímos ao objeto Entities User ($this) o atributo 'reset_hash' que conterá o hash do token.
         */
        $this->reset_hash = $token->getHash();
        
        $this->reset_expires_in = date('Y-m-d H:i:s', time() + 7200); // Expira em 2hrs a partir da data e hora atuais
    }

    public function completePasswordReset() {

        $this->reset_hash = null;
        $this->reset_expira_em = null;
        
    }

    public function startActivation() {
        
        $token = new Token();

        $this->token = $token->getValue();
        $this->activation_hash = $token->getHash();
    }

    public function activate() {

        $this->active = true;
        $this->activation_hash = null;
        
    }
}
