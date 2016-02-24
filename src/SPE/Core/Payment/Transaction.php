<?php

namespace SPE\Core\Payment;

use SPE\Core\Payment\CyberSource\CyberSourceProxy;
use SPE\Core\Payment\CyberSource\Request;

class Transaction {

  public static function getTxnPaymentAmount($merchantreferenceNumber, $transactionDate){
    $csProxy = new CyberSourceProxy();
    $transactionDetailsXml = $csProxy->getTransactionDetailsXml($merchantreferenceNumber, $transactionDate);
//$transactionDetailsXml= null;
    if (!$transactionDetailsXml){
      return null;
    }
    $csRequest = new Request($transactionDetailsXml);
    $paymentAmount = $csRequest->getPaymentAmount($merchantreferenceNumber);
    return $paymentAmount;
    
  }

}
