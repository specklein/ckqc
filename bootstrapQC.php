<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/etc/config/config.php';

use SPE\Core\TestController;

define('APPLICATION_ROOT_FOLDER', realpath(dirname(__FILE__) ));

global $argv, $argc;

$testController = new TestController();

/*
$qcShutdown = function (){
  TestController::shutdown();
};

register_shutdown_function($qcShutdown);
*/

try{ 
  $testController->setUp($argv,$argc);
}catch(Exceptoin $e){
}

