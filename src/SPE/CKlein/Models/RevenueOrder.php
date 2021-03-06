<?php


namespace SPE\CKlein\Models;


use SPE\CKlein\Utils\ShipUtils;

/*
Class that holds values of all fields found in the revenue report
related to one orderId. 
*/
class RevenueOrder {
    
    private $orderId;
    private $orderDate;
    private $orderLines = array();
    private $shipmentLines = array();
    private $orderLineCount=0;
    private $shipmentGtin;
    private $sumOfLinePrice=0;
    private $repeatedSkus = array();
    

    public function getSumOfLineQuantities(){
      $sum = 0;
      foreach($this->orderLines as $orderLine){
	//if item # is a shipping line # ignore the line

	if (ShipUtils::isGtinShippingItem($orderLine->getGtin())) {
          continue;
        }
        //if ($orderLine->getGtin() == '00009999010011'){
        //  continue;
        //}
        $sum = $sum + $orderLine->getQty();
      }
      return $sum;
    }

    public function getSumOfAllQuantities(){
      $sum = 0;
      foreach($this->orderLines as $orderLine){
        $sum = $sum + $orderLine->getQty();       
      }
      return $sum;
    }

    public function isTxnARefund(){
      foreach($this->orderLines as $orderLine){
        if ($orderLine->getQty() < 0 ){
          return true;
        }
      }
      return false;

    }


    public function getSumOfAllRecords(){
      return $this->getSumOfLinePrice()+$this->getSumOfShipLinePrice();

    }

    public function getSumOfShipLinePrice(){
       $sumOfShipLinePrice = 0;
       foreach ($this->shipmentLines as $shipmentLine){
         $sumOfShipLinePrice += $shipmentLine->getPrice();
       }
    }

    public function getSumOfLinePrice(){
        return $this->sumOfLinePrice;
    }
    
    /**
    * @param decimal
    */
    private function addSumOfLinePrice($sumOfLinePrice) {
        $this->sumOfLinePrice = $this->sumOfLinePrice + $sumOfLinePrice;
    }
    
    /**
    * @param decimal
    */
    public function setSumOfLinePrice($sumOfLinePrice) {
        $this->sumOfLinePrice = $sumOfLinePrice;
    }
    
    public function getOrderLines(){
        return $this->orderLines;
    }
    
    /**
    * @param RevenueShipmentLine
    */
    public function addShipmentLine($shipmentLine) {
      $this->shipmentLines[] = $shipmentLine;
      $this->sumOfLinePrice += $shipmentLine->getPrice();
    }
    
    /**
    * @param array RevenueOrderLine
    */
   public function setShipmentLines($shipmentLines) {
      $this->shipmentLines = $shipmentLines;
   }

   /**
    * @return string
    */
   public function getShipmentLines() {
      return $this->shipmentLines;
   }


   private function isOrderLineAdded($newOrderLine){
     foreach($this->orderLines as $orderLine){
       if ($orderLine->getGtin() == $newOrderLine->getGtin()){
        return true;
       }
     }
     return false;
   }


  public function isLineRepeating($productId){
    if (isset($this->repeatedSkus[$productId])){
      return true;
    } else {
      return false;
    }
  }

    /**
    * @param RevenueOrderLine
    */
    public function addOrderLine($orderLine) {
      if ($this->isOrderLineAdded($orderLine)){
        $this->repeatedSkus[$orderLine->getGtin()]=true;
      }
      $this->orderLines[] = $orderLine;
      if ($orderLine->getQty() < 0 ){
        //if refund don't multiple by Qty
        $this->sumOfLinePrice += $orderLine->getPrice();
      }else {
        $this->sumOfLinePrice += ($orderLine->getPrice()*$orderLine->getQty());
      }

    }
    
    /**
    * @param array RevenueOrderLine
    */
   public function setOrderLines($orderLines) {
      $this->orderLines = $orderLines;
   }

   /**
    * @return string
    */
   public function getOrderLineCount() {
      return $this->orderLineCount;
   }

   /**
    * @param string $orderLineCount
    */
   public function setOrderLineCount($orderLineCount) {
      $this->orderLineCount = $orderLineCount;
   }

   public function incrementOrderLineCount(){
     $this->orderLineCount++;
   }
   
   /**
    * @return string
    */
   public function getOrderDate() {
      return $this->orderDate;
   }

   /**
    * @param string $orderDate
    */
   public function setOrderDate($orderDate) {
      $this->orderDate = $orderDate;
   }
   
   /**
    * 
    */
   public function getOrderId() {
      return $this->orderId ;
   }
   
   /**
    * @param string $orderDate
    */
   public function setOrderId($orderId) {
      $this->orderId = $orderId;
   }
   

}
