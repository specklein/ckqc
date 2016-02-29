<?php


namespace SPE\CKlein\Models;

use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;

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

   /**
    * @param string $reportDateStr
    */
   public static function evalReportDate($orderDateStr) {

     if (! $orderDateStr || empty($orderDateStr)) return null;
     $reportCutoffHour = QCConfig::getInstance()->get('reports')[QCConfigKey::_REVENUE_REPORT_CUTOFF_HOUR_CONFIG_KEY];
     $dateFormat = QCConfig::getInstance()->get('reports')[QCConfigKey::_REVENUE_DATEFORMAT_CONFIG_KEY];
     $dateArray = date_parse_from_format($dateFormat, $orderDateStr);
     if ($dateArray['hour'] < $reportCutoffHour) {
       $reportDay=$dateArray['day']-1;
     } else {
       $reportDay=$dateArray['day'];
     } 
     $reportDate = $dateArray['year'].'-'.$dateArray['month'].'-'.$reportDay;

     return $reportDate; 

   }

   public function getOrderIds(){
     $orderIds = array();
     foreach($this->orders as $order){
       $orderIds[]=$order[0]->getOrderId();
     }
     return $orderIds;
   }


}
   

