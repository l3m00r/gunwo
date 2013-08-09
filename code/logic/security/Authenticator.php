<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authenticator
 *
 * @author mateusz
 */
class Authenticator {
    
    public function authenticate() {
        
    }
    
    public function hasAccess() {
        
        if(!(session_status() == PHP_SESSION_ACTIVE)) {
            throw new SecurityException('Session inactive.', ErrorCodes::$SESSION_INACTIVE);
        }
        
        if(!isset($_SESSION['user'])) {
            throw new SecurityException('Not logged in.', ErrorCodes::NOT_LOGGED_IN);
        }
        
        $sessionId = session_id();
        
        $dataManager = DataManager::Create(DataContext::$USER);
        $dataManager->findBy($entities);
    }
}

?>
