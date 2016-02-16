<?php


namespace SPE\CKlein\Models;
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
    private $shipmentQtin;
    private $sumOfLinePrice=0;
    
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


    /**
    * @param RevenueOrderLine
    */
    public function addOrderLine($orderLine) {
      $this->orderLines[] = $orderLine;
      $this->sumOfLinePrice += $orderLine->getPrice();
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
