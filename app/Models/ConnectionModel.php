<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Token;

class ConnectionModel extends Model
{
    protected $table            = 'connections';
    protected $returnType       = 'App\Entities\Connection';
    protected $allowedFields    = ['requester_user_id', 'requested_user_id'];
    
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
    
}
