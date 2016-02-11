<?php

namespace SPE\CKlein\Mappers;

use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Models\RevenueOrder;
use SPE\CKlein\Models\RevenueOrderLine;
use SPE\CKlein\Models\RevenueReport;
use SPE\Core\QCLogger;

class RevenueCSV2Model {
    


  /*
    input is an array of records; each record is another array
    returns an object of type SPE/CKlein/Models/RevenueReport
  */
  public static function transform($csvRecords){

$revenueReport = new RevenueCSV('/home/cklein/revenue-reports/singpost20160118.csv');

$csvRecords = $revenueReport->getCsvRecords()->setOffset(1)->setLimit(7)->fetchAll();

    if (!$csvRecords || count($csvRecords) == 0) return null;
    $logger= QCLogger::getInstance();
    $logger->addInfo("BEGIN RevenueCSV2Model::transform".PHP_EOL);

    $revenueOrders = array();
    $orderCount = 0;
    $revenueReportDate=null;
    foreach($csvRecords as $csvRecord){

      $logger->debug("CSV record ". print_r($csvRecord,true).PHP_EOL);

      $revenueOrderLine = new RevenueOrderLine($csvRecord[4],$csvRecord[5],$csvRecord[6]);

      //Check if order model object is alredy created for the current record
      //if so reuse that object
      if (isset($revenueOrders[$csvRecord[1]])){
	//echo print_r($revenueOrders[$csvRecord[1]],true);
        $revenueOrders[$csvRecord[1]][0]->addOrderLine($revenueOrderLine);
      }else{
        $orderCount++;
        $revenueOrder = new RevenueOrder();
        $revenueOrder->setOrderId($csvRecord[1]);
	$revenueOrder->setOrderDate($csvRecord[0]);
        $revenueOrder->addOrderLine($revenueOrderLine);
        $revenueOrders[$csvRecord[1]] = array();
        $revenueOrders[$csvRecord[1]][] = $revenueOrder;
      }

    } 
    $logger->addDebug("Constructing RevenueReport model obj".PHP_EOL);
    $revenueReportModel = new RevenueReport();
    $revenueReportModel->setOrderCount($orderCount);
    $revenueReportModel->setOrders($revenueOrders);
    $logger->addDebug("Order count = ".$orderCount.PHP_EOL);
    


  }

}
