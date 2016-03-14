<?php

namespace SPE\Core;

use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Utils\RevenueReportUtils;
use SPE\CKlein\Mappers\RevenueCSV2Model;
use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\Core\BaseTestListener;
use SPE\Core\Transform\TestResultTransformer;
use SPE\Core\TestResultHandler;
use Exception;


class TestController {

  function setUp($argv, $argc){

    $logger = QCLogger::getInstance();
    $logger->info("BEGIN ".__METHOD__);
    $revenueReportFile=RevenueReportUtils::getReportFileName($argv);
    if (!$argv) {
      $revenueReportFile = "/tmp/ck-daily-sales.csv";
    }
    Registry::getInstance()->add('revenueReportFile',$revenueReportFile);
    if (!file_exists($revenueReportFile)){
      $exception =  new Exception("Revenue Report file ".$revenueReportFile." is not found");
      $this->handleSetupError($exception);
      throw $exception;
    }
    $revenueReport = new RevenueCSV($revenueReportFile);
    $csvRecords = $revenueReport->getCsvRecords()->setOffset(1)->fetchAll();
    Registry::getInstance()->add('csvRecords',$csvRecords);
    $revenueReportModel = RevenueCSV2Model::transform($csvRecords);
    if ($revenueReportModel){
      $revenueReportModel->setRevenueReportFile($revenueReportFile);
    }
    Registry::getInstance()->add('revReportModel',$revenueReportModel);
    $logger->info("END ".__METHOD__);
  }


  

  static function shutdown(){
    $logger = QCLogger::getInstance();
    if (Registry::getInstance()->isRegistered(BaseTestListener::FAILURE_TESTCASES_KEY)){
      $listOfFailureTCs = Registry::getInstance()->get(BaseTestListener::FAILURE_TESTCASES_KEY);
      if ($listOfFailureTCs && count($listOfFailureTCs) > 0) {
        $logger->info("Test completed with failures...sending email of failures");
        $testResultHandler = new TestResultHandler();
        $testResultHandler->onFailure($listOfFailureTCs);
      }
    }
    if (Registry::getInstance()->isRegistered(BaseTestListener::ERR_TESTCASES_KEY)){
      $listOfErrorTCs = Registry::getInstance()->get(BaseTestListener::ERR_TESTCASES_KEY);
      if ($listOfErrorTCs && count($listOfErrorTCs) > 0) {
        $logger->info("Test completed with errors...sending email of failures");
        $testResultHandler = new TestResultHandler();
        $testResultHandler->onError($listOfErrorTCs);
      }
    }
     
  }

  public static function isTestSuccessful(){

    $registry = Registry::getInstance();

    //logic is if failure and error keys are not registered then setup has failed
    //if they are registered and if they are non-empty then test cases are not successful
    if ($registry->isRegistered(BaseTestListener::FAILURE_TESTCASES_KEY) ){
      if ( Registry::getInstance()->get(BaseTestListener::FAILURE_TESTCASES_KEY)){
        return false;
      }
    }else{
        return false;
    }
    if ( $registry->isRegistered(BaseTestListener::ERR_TESTCASES_KEY)) {
      if ( $registry->get(BaseTestListener::ERR_TESTCASES_KEY)){
        return false;
      }
    }else{
      return false;
    }

    return true;
  }

  private function handleSetupError($exception){
    $testResultHandler = new TestResultHandler();
    $testResultHandler->onSetupError($exception);
  }

}
