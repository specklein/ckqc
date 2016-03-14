<?php

namespace SPE\Core;


use PHPUnit_Framework_TestCase;

class BaseTestCase extends PHPUnit_Framework_TestCase {


  protected static $logger;
  protected static $config;
  protected static $revenueOrdersModel;
  
  /**
  *
  */
  public static function setUpSharedFixtures() {
   // self::$logger = QCLogger::getInstance();
   // self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');
    
    $revenueReportFile=Registry::getInstance()->get('revenueReportFile');
    if (!file_exists($revenueReportFile)){
      throw new \Exception("Revenue Report file ".$revenueReportFile." is not found");
    }else if (filesize($revenueReportFile) == 0){
      throw new \Exception("Revenue report file ".$revenueReportFile." is empty");
    }

    if (!isset(self::$logger)){
     self::$logger = QCLogger::getInstance();
    }
    self::$logger->info("BEGIN ". __METHOD__);
    if (!isset(self::$revenueOrdersModel)){
      self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');
      //if still its not set throw exception
      if (!isset(self::$revenueOrdersModel)){
        throw new \Exception("Not bootstrapped properly; missing revReportModel");
      }
    }
    self::$logger->debug("Revenue orders".PHP_EOL.print_r(self::$revenueOrdersModel->getOrders(),true));
    self::$logger->info("END ". __METHOD__);

  }

  public function testSetup(){
    if ( Registry::getInstance()->isRegistered("revenueReportFile")){
      $revenueReportFile = Registry::getInstance()->get("revenueReportFile");
      $this->assertFileExists($revenueReportFile, "Revenue report (".$revenueReportFile." ) is not found");
    }else{
      $this->assertTrue(false,"revenueReportFile is not set up");
    }
  }



}

