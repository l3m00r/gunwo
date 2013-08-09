<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/IEntityManager.php';

/**
 * SQLEntityManager
 *
 * @author mateusz
 */
abstract class SQLEntityManager implements IEntityManager {
      
    protected $log;
    public $_connection;
    
    abstract public static function Create($config);
    
    public function __construct() {
        $this->log = Logger::getLogger(__CLASS__);
    }
    
    /**
     * @connect
     */
    public function get(IEntity $entity) {
        $this->_connection->open();
        $table = get_class($entity);
        
        $id = $entity->getId();
        $idField = $entity->getIdField();
        $this->_connection->prepare("SELECT * FROM $table WHERE $idField = ?");
        $this->_connection->bindParams(array($id));
        
        $result = $this->_connection->execute();
        $i = count($result);
        
        if($i === 1) {
            return $result[0];
        } elseif ($i === 0) {
            $msg = "No result for id: ".$entity->getId()." in table: ".$table;
            $this->log->error($msg);
            throw new BaseErrorCodeException($msg, ErrorCode::$SQL_EXCEPTION);
        } else {
            $msg = "No unique result for id: ".$entity->getId()." in table: ".$table;
            $this->log->error($msg);
            throw new BaseErrorCodeException($msg, ErrorCode::$SQL_EXCEPTION);
        }
    }
    
    /**
     * @connect
     */
    public function findAll(IEntity $entity) {
        return $this->find($entity, array());
    }
    
    /**
     * @connect
     */
    public function find(IEntity $entity, $criterias) {
      
        $conditions = array();
        $table = get_class($entity);
        
        $qString = "SELECT * FROM $table";
        foreach ($criterias as $criteria) {
            if($table === get_class($criteria->getEntity()))
                $conditions[] = '('.$criteria->createSQLCriteria().')';
            else
                throw new BaseErrorCodeException("Wrong criteria specified.", ErrorCode::$SQL_EXCEPTION);
        }
        if(count($conditions) > 0) {
            $qString .= " WHERE " . implode(" OR ", $conditions);
        }
        $this->_connection->prepare($qString);
    }
    
    /**
     * @connect
     */
    public function delete(IEntity $entity) {
        
        $table = get_class($entity);
        $id = $entity->getId();
        $field = $entity->getIdField();
        $qString = "DELETE FROM $table WHERE $field = ?";
        $this->_connection->prepare($qString);
        $this->_connection->bindParams(array($id));
    }

    /**
     * @connect
     */
    public function save(IEntity $entity) {
        if($this->isNew($entity))
            $this->insert($entity);
        else
            $this->update($entity);
    }
    
    private function insert(IEntity $entity) {
        $idField = $entity->getIdField();
        $table = get_class($entity);
        $qString = "INSERT INTO $table (%s) VALUES (%s)";
        $props = get_object_vars($entity);
        $qMarks = array();
        $pArray = array();
        $vArray = array();
        foreach ($props as $name => $value) {
            if($idField !== $name) {
                $pArray[] = "$name";
                $qMarks[] = ":$name";
                $vArray[$name] = $value;
            }
        }
        
        $qString = sprintf($qString, implode(",", $pArray), implode(",", $qMarks));
        $this->_connection->prepare($qString);
        
        $this->_connection->bindParams($vArray);
    }
    
    private function update(IEntity $entity) {
        
        $table = get_class($entity);
        $idField = $entity->getIdField();
        
        $qString = "UPDATE $table SET %s WHERE $idField = :$idField";
        $vArray = get_object_vars($entity);
        $pArray = array();
        foreach ($vArray as $name => $value) {
            if($name !== $idField) {
                $pArray[] = "$name = :$name";
            }
        }
        
        $qString = sprintf($qString, implode(",", $pArray));
        $this->_connection->prepare($qString);
        
        $this->_connection->bindParams($vArray);
    }

    private function isNew(IEntity $entity) {
        return (is_null($entity->getId()) || $entity->getId() == 0);
    }
}

?>
