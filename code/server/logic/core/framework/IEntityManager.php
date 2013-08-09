<?php

/**
 *
 * @author ei03680
 */
interface IEntityManager {
    
    public function get(IEntity $entity);
    public function save(IEntity $entity);
    public function delete(IEntity $entity);
    public function find(IEntity $entity, $criterias);
}

?>
