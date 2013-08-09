<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseErrorCodeException
 *
 * @author ei03680
 */
class BaseErrorCodeException extends Exception {
    
    public function __construct($message, $code) {
        parent::__construct($message, $code);
    }
}

?>
