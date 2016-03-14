<?php

use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\Core\BaseTestCase;
use SPE\CKlein\Utils\RevenueReportUtils;

class RevenueReportFormatTest extends BaseTestCase {

  protected static $csvRecords;
  protected static $revenueOrdersModel;
  protected static $logger;
  
  /**
  * @beforeClass
  */
  public static function setUpSomeSharedFixtures() {

    self::$logger = QCLogger::getInstance();
    self::$csvRecords = Registry::getInstance()->get('csvRecords');
    self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');

    parent::setUpSharedFixtures();

    
  }

  public function testEachLineFormat(){

    if (!isset(self::$csvRecords)){
      throw new Exception("Not bootstrapped properly. Missing csvRecords");
    }

    //testing the no. of fields in each line
    $lineNum=0;
    foreach (self::$csvRecords as $csvRecord){
      $lineNum++;
      self::$logger->debug("Testing record # ".$lineNum);
      $this->assertEquals(8,count($csvRecord));
    }


  }

  public function testNumberOfOrders(){

  }
}
