<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/IEntity.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author ei03680
 */
class Test implements IEntity {
    
    public $id;
    public $value;
    
    public function getId() {
        return $this->id;
    }

    public function getIdField() {
        return 'id';
    }

    public function serialize() {
        
    }

    public function unserialize($serialized) {
        
    }
}

?>
