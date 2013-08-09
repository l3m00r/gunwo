<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QueryComparator
 *
 * @author mateusz
 */
class QueryComparator {
    
    public static $EQ = 1;
    public static $GT = 2;
    public static $LT = 3;
    public static $GE = 4;
    public static $LE = 5;
    public static $LIKE = 6;
    
    public static function getSQLComparator($op) {
        if($op == QueryComparator::$EQ) return '=';
        if($op == QueryComparator::$GE) return '>=';
        if($op == QueryComparator::$LE) return '<=';
        if($op == QueryComparator::$GT) return '>';
        if($op == QueryComparator::$LT) return '<';
        if($op == QueryComparator::$LIKE) return 'like';
        
        return null;
    }
}

?>
