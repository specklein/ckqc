<?php

require_once __DIR__ . '/vendor/autoload.php';
use SPE\Core\TestController;
use SPE\CKlein\Reports\ConsolidatedReport;


try{

  PHPUnit_TextUI_Command::main(false);
}catch(Exception $e){
}

if (TestController::isTestSuccessful()){
 echo "generate consolidation report";
  $consolidatedReport = new ConsolidatedReport($argv);
  $consolidatedReport->generate();

}else{
 echo "in shutdown";
 TestController::shutdown();
}



