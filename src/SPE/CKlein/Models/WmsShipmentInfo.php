<?php

namespace SPE\CKlein\Models;

class WmsShipmentInfo {
    
  private $wmsOrderNumber;
  private $customerOrderNumber;
  private $shippedDate;
  private $shippedQty;
  private $trackingNumbers = array();

  public function getWmsOrderNumber(){
    return $this->wmsOrderNumber;
  }

  public function setWmsOrderNumber($wmsOrderNumber){
    $this->wmsOrderNumber = $wmsOrderNumber;
  }

  public function getCustomerOrderNumber(){
    return $this->customerOrderNumber;
  }

  public function setCustomerOrderNumber($customerOrderNumber){
    $this->customerOrderNumber = $customerOrderNumber;
  }

  public function getShippedDate(){
    return $this->shippedDate;
  }

  public function setShippedDate($shippedDate){
    $this->shippedDate = $shippedDate;
  }

  public function getShippedQty(){
    return $this->shippedQty;
  }

  public function setShippedQty($shippedQty){
    $this->shippedQty = $shippedQty;
  }

  public function getTrackingNumbers(){
    return $this->trackingNumbers;
  }

  public function setTrackingNumbers($trackingNumbers){
    $this->trackingNumbers = $trackingNumbers;
  }

  public function addTrackingNumber($trackingNumber){
    $this->trackingNumbers[] = $trackingNumber;
  }
    
}
