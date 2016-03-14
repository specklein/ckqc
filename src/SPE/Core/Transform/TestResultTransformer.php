<?php

namespace SPE\Core\Transform;

use SPE\Core\QCLogger;

class TestResultTransformer {

  private $logger;
  
  public function __construct(){
    $this->logger=QCLogger::getInstance();
  }

  public function getFailureHtmlEmailMsg($failedTCs){
 
    $htmlMessage = "<br/>";
    foreach($failedTCs as $failedTC){
      $htmlMessage = "<br/>".$htmlMessage ."Test case (". $failedTC->getName(). ") failed <br/>".$failedTC->getStatusMessage()."<br/><br/>";
    }
    return $htmlMessage;
    
  }

  public function getErrorHtmlEmailMsg($errorTCs){
 
    $htmlMessage = "<br/>";
    foreach($errorTCs as $errorTC){
      $htmlMessage = "<br/>".$htmlMessage ."Test case (". $errorTC[0]->getName(). ") encountered error <br/>".$errorTC[1]->getMessage()."<br/><br/>";
    }
    return $htmlMessage;
    
  }

  public function getSetupErrorHtmlEmailMsg($exception){
    $htmlMessage = "<br/><br/> Test setup exception encountered. Exception <br/>".$exception->getMessage()."<br/><br/><br/>";
    return $htmlMessage;
  }

}
