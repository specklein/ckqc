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
    private $orderLineCount;
    
    public function getOrderLines(){
        return $this->orderLines;
    }
    
    /**
    * @param RevenueOrderLine
    */
    public function addOrderLine($orderLine) {
        $this->orderLines[] = $orderLine;
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
