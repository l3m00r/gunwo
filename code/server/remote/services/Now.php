<?php
require_once '../logic/data/entities/Test.php';
require_once '../logic/data/ContextManager.php';

class Now {
    public function getNow() {
        return date('jS F Y @ g:i:s a');
    }
    
    /**
     * @remotable
     * @secured
     */
    public function selectSample() {
        $em = ContextManager::getData();
        $entity = new Test();
        $result = $em->findAll($entity);
        
        return $result;
    }
}
?>