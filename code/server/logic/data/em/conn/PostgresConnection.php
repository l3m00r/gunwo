<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/conn/SQLConnection.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostgresConnection
 *
 * @author ei03680
 */
class PostgresConnection extends SQLConnection {
    
    public function __construct($config) {
        parent::__construct($config);
    }
    
    protected function parseConnectionString($config) {
        $this->connectionString = sprintf("pgsql:host=%s port=%d dbname=%s user=%s password=%s", 
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['user'],
                $config['password']);
    }
}

?>
