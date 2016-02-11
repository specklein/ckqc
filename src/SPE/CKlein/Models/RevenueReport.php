<?php


namespace SPE\CKlein\Models;

/*
Class that holds all records of a revenue report as a list of RevenueOrders 
*/
class RevenueReport {
    
    private $reportDate;
    private $orders = array();
    private $orderCount;
    
    public function getOrders(){
        return $this->orders;
    }
    
    /**
    * @param RevenueOrder
    */
    public function addOrder($order) {
        $this->orders[] = $order;
    }
    
    /**
    * @param array RevenueOrder
    */
   public function setOrders($orders) {
      $this->orders = $orders;
   }

   /**
    * @return string
    */
   public function getOrderCount() {
      return $this->orderCount;
   }

   /**
    * @param string $orderCount
    */
   public function setOrderCount($orderCount) {
      $this->orderCount = $orderCount;
   }
   
   /**
    * @return string
    */
   public function getReportDate() {
      return $this->reportDate;
   }

   /**
    * @param string $reportDate
    */
   public function setReportDate($reportDate) {
      $this->reportDate = $reportDate;
   }
   

}
