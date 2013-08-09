<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/conn/IConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/exception/BaseErrorCodeException.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/exception/ErrorCode.php';

/**
 * Description of MySQLConnection
 *
 * @author mateusz
 */
abstract class SQLConnection implements IConnection {
    
    protected $log;

    protected $connectionString;

    protected $handler;
    protected $query;

    public function __construct($config) {
        $this->log = Logger::getLogger(__CLASS__);
        
        $this->parseConnectionString($config);
    }
    
    protected abstract function parseConnectionString($config);

    public function close() {
        $this->handler = null;
        $this->log->info("Connection closed.");     
    }

    public function execute() {
        $this->query->execute();
        
        $result = array();
        while($result[] = $this->query->fetchObject());
        
        $this->query->closeCursor();
        return $result;
    }

    public function open() {
        try {
            $this->handler = new PDO($this->connectionString);
            
            $this->log->info("Connection opened.");
        } catch (Exception $e) {
            $this->log->error("Unable to connect to database.", $e);
            throw new BaseErrorCodeException($e->getMessage(), ErrorCode::$DB_CONNECTION_REFUSED);
        }
    }

    public function prepare($query) {
        try {
            $stmt = $this->handler->prepare($query);
            $this->query = $stmt;
            
            $this->log->info("Preparing query: $query");
        } catch (Exception $e) {
            $this->log->error("Unable to prepare query.", $e);
            throw new BaseErrorCodeException($e->getMessage(), ErrorCode::$SQL_EXCEPTION);
        }
    }
    
    public function bindParams($params) {
        try {
            if(!(is_null($params) || is_null($this->query))) {
                foreach ($params as $name => $value) {
                    $this->query->bindParam($name, $value);
                }
            }        
        } catch (Exception $e) {
            $this->log->error("Unable to bind parameters.", $e);
            throw new BaseErrorCodeException($e->getMessage(), ErrorCode::$SQL_EXCEPTION);
        }
    }
}

?>
