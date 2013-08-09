<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/data/ContextManager.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/data/entities/Test.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/logic/core/utils/logging/Logger.php';
            
            $em = ContextManager::getData();
            $entity = new Test();
            $result = $em->findAll($entity);
            var_dump($result);

        ?>
    </body>
</html>
