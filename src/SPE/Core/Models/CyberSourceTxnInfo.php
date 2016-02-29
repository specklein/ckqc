<?php

namespace SPE\Core\Models;

class CyberSourceTxnInfo {

  private $requestDate;
  private $paymentAmount;

  public function getRequestDate(){
    return $this->requestDate;
  }

  public function setRequestDate($requestDate){
    $this->requestDate = $requestDate;
  }

  public function getPaymentAmount(){
    return $this->paymentAmount;
  }

  public function setPaymentAmount($paymentAmount){
    $this->paymentAmount = $paymentAmount;
  }

}

