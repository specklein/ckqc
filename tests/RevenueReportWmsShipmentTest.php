<?php


use SPE\Core\BaseTestCase;
use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\CKlein\Models\RevenueReport;
use SPE\CKlein\DAO\Shipments\WmsShipmentDAO;

class RevenueReportWmsShipmentTest extends BaseTestCase {

  protected static $logger;
  protected static $revenueOrdersModel;
  

  public static function getOrders(){

    parent::setUpSharedFixtures();

    return $revenueOrders = parent::$revenueOrdersModel->getOrders();

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
    $this->logger->info("Testing Order #".$orderId);
    
    $this->logger->info("Checking if this order is present in WMS shipment");

    $wmsShipmentDAO = new WmsShipmentDAO();
    $wmsShipmentInfo = $wmsShipmentDAO->getShipmentInfo($orderId);
    $this->assertNotEmpty($wmsShipmentInfo, "Shipment for order # ".$orderId." is not found in db ");
    $this->logger->info("END ". __METHOD__);

  }



}
