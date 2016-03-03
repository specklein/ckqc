<?php

namespace SPE\Core\Payment;

use SPE\Core\Payment\CyberSource\CyberSourceProxy;
use SPE\Core\Payment\CyberSource\Request;

class Transaction {

  public static function getTxnPaymentAmount($merchantreferenceNumber, $transactionDate){
    $transactionDetailsXml = self::getTxnDetailsXml($merchantreferenceNumber, $transactionDate);
    if (!$transactionDetailsXml){
      return null;
    }
    $csRequest = new Request($transactionDetailsXml);
    $paymentAmount = $csRequest->getPaymentAmount($merchantreferenceNumber);
    return $paymentAmount;
    
  }

  public static function getCyberSourceTxnInfo($merchantreferenceNumber, $transactionDate){

    $csProxy = new CyberSourceProxy();
    $transactionDetailsXml = self::getTxnDetailsXml($merchantreferenceNumber, $transactionDate);
    if (!$transactionDetailsXml){
      return null;
    }
    $csRequest = new Request($transactionDetailsXml);
    $csTxnInfo = $csRequest->getCyberSourceTxnInfo($merchantreferenceNumber);
    return $csTxnInfo;


  }

  public function getCyberSourceTxnSummary($revenueReportModel){
     $csTxnInfoArray = array();
     foreach ($revenueReportModel->getOrders() as $revenueOrder){
       $orderId = $revenueOrder[0]->getOrderId();
       $revOrderDate = date_create($revenueOrder[0]->getOrderDate());
       $revOrderDateFormatted = date_format($revOrderDate,'Ymd');
       $csTxnInfo = self::getCyberSourceTxnInfo($orderId, $revOrderDateFormatted);
       $csTxnInfoArray[$orderId] = $csTxnInfo;
    }
    return $csTxnInfoArray;

  }


  private static function getTxnDetailsXml($merchantreferenceNumber, $transactionDate){
    $csProxy = new CyberSourceProxy();
    return $csProxy->getTransactionDetailsXml($merchantreferenceNumber, $transactionDate);
 }

}
