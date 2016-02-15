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
  

  /**
  * 
  */
  public static function setUpSharedFixtures() {
   // self::$logger = QCLogger::getInstance();
   // self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');

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

  }


  public static function getOrders(){

    self::setUpSharedFixtures();

    return $revenueOrders = self::$revenueOrdersModel->getOrders();

  }

  /**
   * @dataProvider getOrders
   */
  public function testOrder($revenueOrder){

    $this->logger = QCLogger::getInstance();
    $this->logger->info("BEGIN ". __METHOD__);

    $orderId = $revenueOrder->getOrderId();
    $this->logger->info("Testing Order #".$orderId);
    $this->logger->info("Sum of all prices for this order # - present in the report = ".$revenueOrder->getSumOfLinePrice());
    $this->logger->info("Checking against the value in db");

    $dwOrderDAO = new DwOrderDAO();
    $dwOrderInfo = $dwOrderDAO->getOrderInfo($orderId);
    $this->assertEquals(false,empty($dwOrderInfo),"Order, ".$orderId.", is not found in db");
//    $this->assertEquals($revenueOrder->getSumOfLinePrice(), $dwOrderInfo->getOrderGrossPrice(),"Sum of prices for order ".$orderId." in report is = ".$revenueOrder->getSumOfLinePrice(). ". It is not matching with the gross price value ".$dwOrderInfo->getOrderGrossPrice() ." found in db ");
    $revenueOrderLines = $revenueOrder->getOrderLines();
    foreach( $revenueOrderLines as $revenueOrderLine){
      $this->logger->info("Checking for orderLine : productId : ".$revenueOrderLine->getGtin());
      $revenueGtin=ltrim($revenueOrderLine->getGtin(),'0');
      $revenueQty=$revenueOrderLine->getQty();
      $revenuePrice=$revenueOrderLine->getPrice();
      $dwOrderLines=$dwOrderInfo->getOrderLines();
      $this->logger->debug("dw-order-lines from db for order-id ".$orderId. " ".print_r($dwOrderLines,true));
      $this->assertNotEmpty($dwOrderLines[$revenueGtin],"Order Line having GTIN  - ".$revenueGtin." is not found in the db");
      $adjPriceFromDb = $dwOrderLines[$revenueGtin][0]->getAdjGrossPrice();
      $this->assertEquals($revenuePrice, $adjPriceFromDb, "Price in revenue file for GTIN ".$revenueGtin." is not same as in db (".$adjPriceFromDb.")");
    }
    
    $this->logger->info("END ". __METHOD__);


  }



}
