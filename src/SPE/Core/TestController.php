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


class TestController {

  function setUp($argv, $argc){
    $revenueReportFile=RevenueReportUtils::getReportFileName($argv);
    if (!$argv) {
      $revenueReportFile = "/tmp/ck-daily-sales.csv";
    }
    $revenueReport = new RevenueCSV($revenueReportFile);
    $csvRecords = $revenueReport->getCsvRecords()->setOffset(1)->fetchAll();
    Registry::getInstance()->add('csvRecords',$csvRecords);
    $revenueReportModel = RevenueCSV2Model::transform($csvRecords);
    Registry::getInstance()->add('revReportModel',$revenueReportModel);
  }

  static function shutdown(){
    $logger = QCLogger::getInstance();
    $listOfFailureTCs = Registry::getInstance()->get(BaseTestListener::FAILURE_TESTCASES_KEY);
    if ($listOfFailureTCs && count($listOfFailureTCs) > 0) {
      $logger->info("Test completed with failures...sending email of failures");
      $testResultHandler = new TestResultHandler();
      $testResultHandler->onFailure($listOfFailureTCs);
    }
     
  }


}
