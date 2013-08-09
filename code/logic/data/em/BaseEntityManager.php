<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/SQLEntityManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/data/em/conn/PostgresConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/data/em/conn/MySQLConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/data/em/conn/ConnectionHandler.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestEntityManager
 *
 * @author ei03680
 */
class BaseEntityManager extends SQLEntityManager {
    
    public function __construct($config) {
        parent::__construct();
        if($config['conn'] === 'mysql') {
            $this->_connection = new MySQLConnection($config);
            $this->log->info("MySQL connection created.");
        }
        elseif($config['conn'] === 'postgres') {
            $this->_connection = new PostgresConnection($config);
            $this->log->info("PostgreSQL connection created.");
        }
        else {
            $this->log->error("Undefined connection type. Check DB configuration file.");
            throw new BaseErrorCodeException("Undefined connection type.", ErrorCode::UNDEFINED_CONNECTION);
        }
    }

    public static function Create($config) {
        return new ConnectionHandler(new BaseEntityManager($config));
    }
    
}

?>
