<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/framework/interceptors/AInterceptor.php';
/**
 * ConnectionHandler is used to intercept EntityManagers operations
 * to open/close/execute connections
 *
 * @author mateusz
 */
class ConnectionHandler extends AInterceptor {
    function around($method, $args){
        $class = get_class($this->_rootObject);
        $clazz = new ReflectionClass($class);
        if($clazz->hasMethod($method)) {
            $mettod = $clazz->getMethod($method);
            $doc = $mettod->getDocComment();
            if(
                strlen($doc) > 0 &&
                !!preg_match('/@connect/', $doc)
            )
            {
                try {
                    if($this->log->isDebugEnabled())
                        $this->log->debug("Intercepting method $method...");
                    $this->_rootObject->_connection->open();
                    $this->callMethod($method, $args);
                    $value = $this->_rootObject->_connection->execute();
                    $this->_rootObject->_connection->close();
                    return $value;
                } catch (BaseErrorCodeException $e) {
                    $this->log->error("Safely closing connection...");
                    $this->_rootObject->_connection->close();
                    throw new BaseErrorCodeException($e->getMessage(), $e->getCode());
                } catch (Exception $e) {
                    $this->log->error("Unexpected problem during interception occured.");
                    throw new BaseErrorCodeException("Unexpected problem ocured", ErrorCode::INTERCEPTION_ERROR);
                }
            }
            else {
                return $this->_object->callMethod($method, $args);
            }
        }            
    }
}

?>
