<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author mateusz
 */
interface IConnection {
    
    public function open();
    public function close();
    public function prepare($query);
    public function execute();
}

?>
