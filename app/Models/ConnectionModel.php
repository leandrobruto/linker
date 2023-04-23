<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Token;

class ConnectionModel extends Model
{
    protected $table            = 'connections';
    protected $returnType       = 'App\Entities\Connection';
    protected $allowedFields    = ['requester_user_id', 'requested_user_id', 'status'];
    
    // Dates
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $dateFormat       = 'datetime'; // Para uso com o $softDelete
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at';

    // Validation
    protected $validationRules = [
        'requester_user_id' => 'required',
        'requester_user_id' => 'required',
    ];

    protected $validationMessages = [        
        'requester_user_id' => [
            'required' => 'O usuário solicitante não foi informado.',
        ],
        'requested_user_id' => [
            'required' => 'O usuário solicitante não foi informado.',
        ],
    ];

    public function getConnections($requester_id) {

        return $this->select('users.*')
                        ->join('users', 'users.id = connections.requested_user_id')
                        ->where('connections.requester_user_id', $requester_id)
                        ->orderBy('users.name', 'ASC')
                        ->findAll();
    }

    public function countConnections($requester_id) {

        return $this->where('connections.requester_user_id', $requester_id)
                        ->orWhere('connections.requested_user_id', $requester_id)
                        ->where('status', 1)
                        ->countAllResults(); // 
    }
    
}
