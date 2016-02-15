<?php

//require_once __DIR__ . '/../bootstrapQC.php';

use SPE\Core\BaseTestCase;
use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\CKlein\Models\RevenueReport;
use SPE\CKlein\DAO\Orders\DwOrderDAO;

//class RevenueReportPriceTest extends PHPUnit_Framework_TestCase {
class RevenueReportPriceTest extends BaseTestCase {

  private static $logger;
  private static $revenueOrdersModel;
  

/*
  public function __construct(){
    $this->logger = QCLogger::getInstance();
    parent::__construct();
  }
*/

  /**
  * @beforeClass
  */
  public static function setUpSharedFixtures() {
    self::$logger = QCLogger::getInstance();
    self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');
  }


  public static function getOrders(){

    if (!isset(self::$logger)){
     self::$logger = QCLogger::getInstance();
    }
    self::$logger->info("BEGIN ". __METHOD__);
    if (!isset(self::$revenueOrdersModel)){
      self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');
      //if still its not set throw exception
      if (!isset(self::$revenueOrdersModel)){
        throw new Exception("Not bootstrapped properly. Missing revenueOrdersModel");
      }
    }
    self::$logger->debug("Revenue orders".PHP_EOL.print_r(self::$revenueOrdersModel->getOrders()));
    self::$logger->info("END ". __METHOD__);

    return $revenueOrders = self::$revenueOrdersModel->getOrders();

    //foreach($revenueOrders as $revenueOrder){
//
//	$this->checkOrder($revenueOrder);
    //}

  }

  /**
   * @dataProvider getOrders
   */
  public function testOrder($revenueOrder){

    $this->logger = QCLogger::getInstance();
    $this->logger->info("BEGIN ". __METHOD__);

    $orderId = $revenueOrder->getOrderId();
    $this->logger->debug("Testing Order #".$orderId);
    $this->logger->debug("Sum of all prices for this order # - present in the report = ".$revenueOrder->getSumOfLinePrice());
    $this->logger->debug("Checking against the value in db");

    $dwOrderDAO = new DwOrderDAO();
    $orderInfo = $dwOrderDAO->getOrderInfo($orderId);
    $this->assertEquals(false,empty($orderInfo),"Order, ".$orderId.", is not found in db");
    $this->assertEquals($revenueOrder->getSumOfLinePrice(), $orderInfo->getOrderGrossPrice(),"Sum of prices for order ".$orderId." in Report is = ".$revenueOrder->getSumOfLinePrice(). ". It is not matching with the gross price value ".$orderInfo->getOrderGrossPrice() ." found in db ");

    
    $this->logger->info("END ". __METHOD__);


  }

}
