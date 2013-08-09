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
class Operator {
    
    public static $EQ = 1;
    public static $GT = 2;
    public static $LT = 3;
    public static $GE = 4;
    public static $LE = 5;
    public static $LIKE = 6;
    
    public static function getSQLComparator($op) {
        if($op === Operator::$EQ) return '=';
        if($op === Operator::$GE) return '>=';
        if($op === Operator::$LE) return '<=';
        if($op === Operator::$GT) return '>';
        if($op === Operator::$LT) return '<';
        if($op === Operator::$LIKE) return 'like';
        
        return null;
    }
}

?>
