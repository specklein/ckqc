<?php

use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\CKlein\Models\RevenueReport;

class RevenueReportOrderDatesTest extends PHPUnit_Framework_TestCase {

  private static $csvRecords;
  private static $logger;
  
  /**
  * @beforeClass
  */
  public static function setUpSomeSharedFixtures() {

    self::$logger = QCLogger::getInstance();
    self::$csvRecords = Registry::getInstance()->get('csvRecords');
  }


  public function testOrderDates(){

    if (!isset(self::$csvRecords)){
      throw new Exception("Not bootstrapped properly. Missing csvRecords");
    }

    $previousOrderRevenueReportDate;
    //testing the no. of fields in each line
    $lineNum=0;
    foreach (self::$csvRecords as $csvRecord){
      $lineNum++;
      self::$logger->debug("Testing record # ".$lineNum);
      if (!isset($previousOrderRevenueReportDate)){
        $previousOrderRevenueReportDate = RevenueReport::evalReportDate($csvRecord[0]);
      }else{
        $this->assertEquals($previousOrderRevenueReportDate,RevenueReport::evalReportDate($csvRecord[0]));
      }
    }


  }

}
