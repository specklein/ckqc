<?php

namespace SPE\CKlein\Mappers;

class ConsolidatedReportOrders2Array{

  public static function getReportDataInArray($dbRecords,$revenueReportModel,$csTxnInfo){

    $revenueOrders = $revenueReportModel->getOrders();
    $reportDataArray = array();
    foreach($dbRecords as $dbRecord){
      $lineArray=array();
      $lineArray[0]=$dbRecord[0];
      $lineArray[1]=$dbRecord[1];
      $lineArray[2]=$dbRecord[2];
      $lineArray[3]=$dbRecord[3];
      $lineArray[4]=$dbRecord[4];
      $lineArray[5]=$dbRecord[5];
      if(!isset($revenueOrders[$dbRecord[0]])){
        //throw new Exception("Revenue report info not availble for orderId".$dbRecord[0]);
        continue;
      }
      $revenueOrder = $revenueOrders[$dbRecord[0]][0];
      $lineArray[]=$revenueOrder->getOrderDate();
      $lineArray[]=$revenueOrder->getSumOfAllRecords();
      $lineArray[]=$revenueOrder->getSumOfAllQuantities();
      if(!isset($csTxnInfo[$dbRecord[0]])){
        //throw new Exception("CyberSource info not availble for orderId".$dbRecord[0]);
        continue;
      }
      $csTxnRecord = $csTxnInfo[$dbRecord[0]];
      $lineArray[]=$csTxnRecord->getRequestDate();
      $lineArray[]=$csTxnRecord->getPaymentAmount();
      $reportDataArray[]=$lineArray;
    }
    return $reportDataArray;
  }

}
