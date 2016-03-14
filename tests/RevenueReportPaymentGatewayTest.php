<?php

//require_once __DIR__ . '/../bootstrapQC.php';

use SPE\Core\BaseTestCase;
use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\CKlein\Models\RevenueReport;
use SPE\CKlein\DAO\Orders\DwOrderDAO;
use SPE\Core\Payment\Transaction;

class RevenueReportPaymentGatewayTest extends BaseTestCase {

  protected static $logger;
  protected static $revenueOrdersModel;
  

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
    self::$logger->debug("Revenue orders".PHP_EOL.print_r(self::$revenueOrdersModel->getOrders(),true));
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
    $this->logger->debug("Received Revenue Order :".print_r($revenueOrder,true));
    //check if the txn is a refund and if so ignore the Cybersource validation
    if ($revenueOrder->isTxnARefund()){
      $this->logger->debug("Transaction is a refund and ignoring the verification");
      return;
    }
    $orderId = $revenueOrder->getOrderId();
    $revOrderDate = date_create($revenueOrder->getOrderDate());
    $revOrderDateFormatted = date_format($revOrderDate,'Ymd');
    $this->logger->info("Testing Order #".$orderId . "with orderDate = ".$revOrderDateFormatted);
    $this->logger->info("Sum of all prices for this order # - present in the report = ".$revenueOrder->getSumOfLinePrice());
    $this->logger->info("Checking against the payment registered in Payment Gateway");
    $txnPaidAmount = Transaction::getTxnPaymentAmount($orderId,$revOrderDateFormatted);
    $this->assertEquals($revenueOrder->getSumOfAllRecords(),$txnPaidAmount,"Total of all records for orderId ".$orderId." in the report is not same as the Payment done in Payment-Gateway, which is ".$txnPaidAmount);

  }



}
