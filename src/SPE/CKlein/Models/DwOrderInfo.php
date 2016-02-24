<?php

namespace SPE\CKlein\Models;

class DwOrderInfo {
    
    private $orderId;
    private $orderLines = array();
    private $orderLineCount=0;
    private $orderDate;
    private $orderGrossPrice;
    private $orderPromoGrossPrice=0;
    private $shippingLines = array();
    private $shippingLineCount=0;
    private $sumOfAllOrderLineQty=0;
    private $merchantGrossPrice=0;
    private $sumOfOrderLineGPPostLineAdj=0;
    
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
    
    public function setMerchantGrossPrice($merchantGrossPrice){
        return $this->merchantGrossPrice=$merchantGrossPrice;
    }
    
    public function getMerchantGrossPrice(){
        return $this->merchantGrossPrice;
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
    
    public function setSumOfAllOrderLineQty($sumOfAllOrderLineQty){
        return $this->sumOfAllOrderLineQty=$sumOfAllOrderLineQty;
    }
    
    public function getSumOfOrderLineGPPostLineAdj(){
        return $this->sumOfOrderLineGPPostLineAdj;
    }
    
    public function getSumOfAllOrderLineQty(){
        return $this->sumOfAllOrderLineQty;
    }
    
    /**
    * @param Order_Models_OrderLine
    */
    public function addOrderLine($orderLine) {
      $this->orderLines[ltrim($orderLine->getProductId(),'0')][] = $orderLine;
      $this->orderLineCount ++;
      $this->sumOfAllOrderLineQty+= $orderLine->getQty();
      $this->sumOfOrderLineGPPostLineAdj += $orderLine->getGrossPrice()+$orderLine->getPromoGrossPrice();
    }
    
    /**
    * @param array Order_Models_OrderLine
    */
   public function setOrderLines($orderLines) {
      $this->orderLines = $orderLines;
      $this->orderLineCount = count($orderLines);
   }
    
    public function getShippingLines(){
        return $this->shippingLines;
    }
    
    /**
    * @param Order_Models_ShippingLine
    */
    public function addShippingLine($shippingLine) {
      $this->shippingLines[ltrim($shippingLine->getProductId(),'0')][] = $shippingLine;
      $this->shippingLineCount ++;
    }
    
    /**
    * @param array Order_Models_ShippingLine
    */
   public function setShippingLines($shippingLines) {
      $this->shippingLines = $shippingLines;
      $this->shippingLineCount = count($shippingLines);
   }

   /**
    * @return string
    */
   public function getShippingLineCount() {
      return $this->orderShippingLineCount;
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
