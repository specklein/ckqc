<?php

namespace SPE\CKlein\Models;

clsas CyberSourceOrderInfo {

  private $authorizationDate;
  private $authorizationValue;
  private $settlementDate;
  private $settlementValue;
  private $merchantReferenceNumber;


  public function getAuthorizationValue(){
    return $this->authorizationValue;
  }

  public function setAuthorizationValue($authorizationValue){
    $this->authorizationValue = $authorizationValue;
  }

  public function getSettlementDate(){
    return $this->settlementDate;
  }

  public function setSettlementDate($settlementDate){
    $this->settlementDate = $settlementDate;
  }

  public function getSettlementValue(){
    return $this->settlementValue;
  }

  public function setSettlementValue($settlementValue){
    $this->settlementValue = $settlementValue;
  }

  public function getMerchantReferenceNumber(){
    return $this->merchantReferenceNumber;
  }

  public function setMerchantReferenceNumber($merchantReferenceNumber){
    $this->merchantReferenceNumber = $merchantReferenceNumber;
  }  
}
