<?php

if (!function_exists('connCount($user_id)')) {
    
    function connCount($user_id) {
        
        $connectionModel = new \App\Models\ConnectionModel();

        return $connectionModel->countConnections($user_id);
    }
}