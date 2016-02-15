<?php

namespace SPE\CKlein\Models;

class DwOrderInfo {
    
    private $orderId;
    private $orderLines = array();
    private $orderLineCount;
    private $orderDate;
    private $orderGrossPrice;
    
    public function getOrderGrossPrice(){
        return $this->orderGrossPrice;
    }
    
    public function setOrderGrossPrice($orderGrossPrice){
        $this->orderGrossPrice=$orderGrossPrice;
    }
    
    public function getOrderLines(){
        return $this->orderLines;
    }
    
    /**
    * @param Order_Models_OrderLine
    */
    public function addOrderLine($orderLine) {
        $this->orderLines[ltrim($orderLine->getProductId(),'0')][] = $orderLine;
    }
    
    /**
    * @param array Order_Models_OrderLine
    */
   public function setOrderLines($orderLines) {
      $this->orderLines[ltrim($orderLine->getProductId(),'0')] = $orderLines;
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
   

}
