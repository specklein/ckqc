<?php

namespace SPE\CKlein\Mappers;

use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Models\RevenueOrder;
use SPE\CKlein\Models\RevenueOrderLine;
use SPE\CKlein\Models\RevenueReport;
use SPE\Core\QCLogger;
use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;

class RevenueCSV2Model {
    


  /*
  * input is an array of revenue records; each record is another array
  * returns an object of type SPE/CKlein/Models/RevenueReport
  */
  public static function transform($csvRecords){

    if (!$csvRecords || count($csvRecords) == 0) return null;

    $logger= QCLogger::getInstance();
    $logger->addInfo("BEGIN RevenueCSV2Model::transform".PHP_EOL);

    $shipmentQtin = QCConfig::getInstance()->get('reports')[QCConfigKey::_REVENUE_REPORT_SHIPMENT_GTIN_CONFIG_KEY];

    $revenueOrders = array();
    $orderCount = 0;
    $revenueReportDate=null;

    foreach($csvRecords as $csvRecord){

      $logger->debug("CSV record ". print_r($csvRecord,true).PHP_EOL);


      //Check if order model object is alredy created for the current record
      //if so reuse that object
      if (!isset($revenueOrders[$csvRecord[1]])) {
        $orderCount++;
        $revenueOrder = new RevenueOrder();
        $revenueOrder->setOrderId($csvRecord[1]);
	$revenueOrder->setOrderDate($csvRecord[0]);
      //  $revenueOrder->addOrderLine($revenueOrderLine);
        $revenueOrders[$csvRecord[1]] = array();
        $revenueOrders[$csvRecord[1]][] = $revenueOrder;
      }
      //echo print_r($revenueOrders[$csvRecord[1]],true);
      if ($csvRecord[4] == $shipmentQtin){
        $revenueShipmentLine = new RevenueShipmentLine($csvRecord[4],$csvRecord[5],$csvRecord[6]);
        $revenueOrders[$csvRecord[1]][0]->addShipmentLine($revenueShipmentLine);
      }else{
        $revenueOrderLine = new RevenueOrderLine($csvRecord[4],$csvRecord[5],$csvRecord[6]);
        $revenueOrders[$csvRecord[1]][0]->addOrderLine($revenueOrderLine);
      }
      //adding price 
      $revenueOrders[$csvRecord[1]][0]->addSumOfLinePrice($csvRecord[6]);
      

    } 
    $logger->addDebug("Constructing RevenueReport model obj".PHP_EOL);
    $revenueReportModel = new RevenueReport();
    $revenueReportModel->setOrderCount($orderCount);
    $revenueReportModel->setOrders($revenueOrders);
    $logger->addDebug("Order count = ".$orderCount.PHP_EOL);
    return $revenueReportModel;
    


  }

}
