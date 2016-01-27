<?php

class Order {
    
    private $orderId;
    private $orderLines = array();
    private $orderLineCount;
    private $orderDate;
    
    public getOrderLines(){
        return $this->orderLines;
    }
    
    /**
    * @param Order_Models_OrderLine
    */
    public function addOrderLine($orderLine) {
        $this->orderLines[] = $orderLine;
    }
    
    /**
    * @param array Order_Models_OrderLine
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
   

}