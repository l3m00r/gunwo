<?php
require_once dirname(__FILE__) . '/../../utils/logging/Logger.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AInterceptor
 *
 * @author mateusz
 */
abstract class AInterceptor {
    protected $log;
    public $_object;
    public $_rootObject; 
 
    public function __construct($object) {
        $this->log = Logger::getLogger(__CLASS__);
        $this->_object = $object;

        if (is_a($object, "AInterceptor"))
                $this->_rootObject = $object->_rootObject;
        else
                $this->_rootObject = $object;

        $object->intercepted = $this; 
    }

    public function callMethod($method, $args){
            return call_user_func_array(array($this->_object, $method), $args);
    }

    public function __isset($name) {
            return isset($this->_rootObject->$name);
    }

    public function __unset($name) {
            unset($this->_rootObject->$name);
    }

    public function __set($name, $value) {
            $this->_rootObject->$name = $value;
    }

    public function __get($name) {
            return $this->_rootObject->$name;
    }

    public function __call($method, $args) {
            if ($method[0] == "_")
                    $method = substr($method, 1);

            if (method_exists($this, "around"))
                    $value = $this->around($method, $args);

            return $value; 
    }
}

?>
