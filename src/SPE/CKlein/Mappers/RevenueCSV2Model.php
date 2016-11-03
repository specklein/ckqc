<?php

namespace SPE\CKlein\Mappers;

use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Models\RevenueOrder;
use SPE\CKlein\Models\RevenueOrderLine;
use SPE\CKlein\Models\RevenueShipmentLine;
use SPE\CKlein\Models\RevenueReport;
use SPE\Core\QCLogger;
use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;
use SPE\CKlein\Utils\ShipUtils;

class RevenueCSV2Model {
    


  /*
  * input is an array of revenue records; each record is another array
  * returns an object of type SPE/CKlein/Models/RevenueReport
  */
  public static function transform($csvRecords){

    if (!$csvRecords || count($csvRecords) == 0) return null;

    $logger= QCLogger::getInstance();
    $logger->addInfo("BEGIN RevenueCSV2Model::transform".PHP_EOL);

    $shipmentGtin = QCConfig::getInstance()->get('reports')[QCConfigKey::_REVENUE_REPORT_SHIPMENT_GTIN_CONFIG_KEY];

    $revenueOrders = array();
    $orderCount = 0;
    $revenueReportDate=null;

    foreach($csvRecords as $csvRecord){

      $logger->debug("CSV record ". print_r($csvRecord,true).PHP_EOL);


      //Check if order model object is alredy created for the current record
      //if so reuse that object
      if (!isset($revenueOrders[$csvRecord[1]])) {
        $orderCount=1;
        $revenueOrder = new RevenueOrder();
        $revenueOrder->setOrderId($csvRecord[1]);
	$revenueOrder->setOrderDate($csvRecord[0]);
        $revenueOrders[$csvRecord[1]] = array();
        $revenueOrders[$csvRecord[1]][] = $revenueOrder;
      }
      //if ($csvRecord[5] == $shipmentGtin){
      if (ShipUtils::isGtinShippingItem($csvRecord[5])) {
        $revenueShipmentLine = new RevenueShipmentLine($csvRecord[5],$csvRecord[6],$csvRecord[7]);
        $revenueOrders[$csvRecord[1]][0]->addShipmentLine($revenueShipmentLine);
      }else{
        $revenueOrderLine = new RevenueOrderLine($csvRecord[5],$csvRecord[6],$csvRecord[7]);
        $revenueOrders[$csvRecord[1]][0]->addOrderLine($revenueOrderLine);
        $revenueOrders[$csvRecord[1]][0]->incrementOrderLineCount();
      }
      //adding price 
      //$revenueOrders[$csvRecord[1]][0]->addSumOfLinePrice($csvRecord[6]);
      

    } 
    $logger->addDebug("Constructing RevenueReport model obj".PHP_EOL);
    $revenueReportModel = new RevenueReport();
    $revenueReportModel->setOrderCount($orderCount);
    $revenueReportModel->setOrders($revenueOrders);
    $logger->addDebug("Order count = ".$orderCount.PHP_EOL);
    return $revenueReportModel;
    


  }

}
