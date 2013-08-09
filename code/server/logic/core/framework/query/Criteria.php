<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Criteria
 *
 * @author ei03680
 */
class Criteria {
    
    private $entity;
    private $comparators;
    private $params;
    
    public function __construct($entity) {
        $this->entity = $entity;
        $this->comparators = [];
        $this->params = [];
    }
    
    public function add($field, $value, $comparator) {
        $this->entity->$field = $value;
        $this->comparators[$field] = $comparator;
        $this->params[] = $value;
    }
    
    public function createSQLCriteria() {
        $result = [];
        foreach ($this->comparators as $field => $cmp) {
            $comparator = QueryComparator::getSQLComparator($cmp);
            $result[] = "$field $comparator :$field";
        }
        
        return implode(" and ", $result);
    }
    
    public function getParams() {
        return $this->params;
    }
    
    public function getEntity() {
        return $this->entity;
    }
}

?>
