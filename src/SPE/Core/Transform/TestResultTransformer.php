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

}
