<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Token;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = 'App\Entities\User';
    protected $allowedFields    = ['email', 'name', 'username', 'password', 'reset_hash', 'reset_expires_in', 'activation_hash'];
    
    // Dates
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $dateFormat       = 'datetime'; // Para uso com o $softDelete
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at';

    // Validation
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'name' => 'required|min_length[4]|max_length[120]',
        'username' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];

    protected $validationMessages = [        
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'is_unique' => 'Desculpe. Esse email já existe.',
        ],
        'name' => [
            'required' => 'O campo Nome é obrigatório.',
        ],
        'username' => [
            'required' => 'O campo Username é obrigatório.',
            'is_unique' => 'Desculpe. Esse Username já existe.',
        ],
        'password' => [
            'required' => 'O campo Senha é obrigatório.',
        ],
        'password_confirmation' => [
            'required_with' => 'O campo Confirmar Senha é obrigatório.',
        ],
    ];

    // Eventos callback
    protected $beforeInsert = ['hasPassword'];
    protected $beforeUpdate = ['hasPassword'];

    public function hasPassword (array $data) {

        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
        }

        return $data;
    }

     /**
     * @uso Controller users no método search com o autocomplete
     * @param string $term
     * @return array users
     */
    public function search($term) {

        if ($term === null) {

            return [];
        }


        return $this->select('id, name')
                        ->like('name', $term)
                        ->withDeleted(true)
                        ->get()
                        ->getResult();
    }

    public function desabilitaValidacaoSenha () {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }

    /**
     * @uso Classe Autentication
     * @param string $email
     * @return object $user
     */
    public function findByEmail(string $email) {

        return $this->where('email', $email)->first();

    }

    /**
     * @uso Classe Autentication
     * @param string $email
     * @return object $user
     */
    public function findByEmailOrUsername(string $email_username) {

        return $this->where('email', $email_username)->orWhere('username', $email_username)->first();

    }

    public function findUserToResetPassword(string $token) {

        $token = new Token($token);

        $tokenHash = $token->getHash();

        $user = $this->where('reset_hash', $tokenHash)->first();

        if ($user != null) {

            /**
             * Verificamos se o token não está expirado de acordo com a data e hora atuais
             */
            if ($user->reset_expires_in < date('Y-m-d H:i:s')) {

                /**
                 * Token está expirado, então setamos o $usuario = null
                 */
                $user = null;
            }

            return $user;
        }
    }

    public function activateAccountByToken(string $token) {

        $token = new Token($token);

        $tokenHash = $token->getHash();

        $user = $this->where('activation_hash', $tokenHash)->first();

        if ($user != null) {
            
            $user->activate();

            $this->protect(false)->save($user);
        }
    }

    public function recuperaTotalClientesAtivos() {

        return $this->where('is_admin', false)
                    ->where('ativo', true)
                    ->countAllResults();
    }
}
