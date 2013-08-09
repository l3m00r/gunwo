<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySQLConnection
 *
 * @author ei03680
 */
class MySQLConnection extends SQLConnection {

    private $user;
    private $password;
    
    protected function parseConnectionString($config) {
        $this->connectionString = sprintf("mysql:host=%s;dbname=%s;", 
            $config['host'],
            $config['dbname']);
        
        $this->user = $config['user'];
        $this->password = $config['password'];
    }
    
    public function open() {
        try {
            $this->handler = new PDO($this->connectionString, $this->user, $this->password);
            
            $this->log->info("Connection opened.");
        } catch (Exception $e) {
            $this->log->error("Unable to connect to database.", $e);
            throw new BaseErrorCodeException($e->getMessage(), ErrorCode::$DB_CONNECTION_REFUSED);
        }
    }
}

?>
