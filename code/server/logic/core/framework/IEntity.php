<?php

/**
 *
 * @author mateusz
 */
interface IEntity extends Serializable {

    public function getId();
    public function getIdField();
}

?>
