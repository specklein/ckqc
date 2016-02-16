<?php

namespace SPE\CKlein\Models;

class DwOrderInfo {
    
    private $orderId;
    private $orderLines = array();
    private $orderLineCount;
    private $orderDate;
    private $orderGrossPrice;
    private $orderPromoGrossPrice=0;
    
    public function getAdjGrossPrice(){
      //note promoGrossPrice is in negative - should not substract
      return $this->orderGrossPrice+$this->orderPromoGrossPrice;
    }

    public function getOrderPromoGrossPrice(){
        return $this->orderPromoGrossPrice;
    }
    
    public function setOrderPromoGrossPrice($orderPromoGrossPrice){
      if (!empty($orderPromoGrossPrice)) {
        $this->orderPromoGrossPrice=$orderPromoGrossPrice;
      }
    }
    
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
      $this->orderLineCount ++;
    }
    
    /**
    * @param array Order_Models_OrderLine
    */
   public function setOrderLines($orderLines) {
      $this->orderLines[ltrim($orderLine->getProductId(),'0')] = $orderLines;
      $this->orderLineCount = count($orderLines);
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
