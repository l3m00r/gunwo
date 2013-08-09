<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/data/em/BaseEntityManager.php';

/**
 * Description of ContextManager
 *
 * @author mateusz
 */
class ContextManager {
    
    private static $data = 'data';
    private static $session = 'session';
    private static $users = 'users';
    
    private static $confFile = 'db.ini';

    private static function parseConfigFile() {
        $src = $_SERVER['DOCUMENT_ROOT'] . '/conf/' . ContextManager::$confFile;
        return parse_ini_file($src, true);
    }
    
    private static function getContext($ctx) {
        $config = ContextManager::parseConfigFile();
        if(!is_null($config[$ctx])) {
            return BaseEntityManager::Create($config[$ctx]);
        }
    }


    public static function getData() {
        return ContextManager::getContext(ContextManager::$data);
    }
    
    public static function getSession() {
        return ContextManager::getContext(ContextManager::$session);
    }
    
    public static function getUsers() {
        return ContextManager::getContext(ContextManager::$users);
    }
}

?>
