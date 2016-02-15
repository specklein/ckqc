<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\Core\QCConfigKey;
use SPE\CKlein\DAO\Orders\DwDbAbstract;
use SPE\CKlein\Models\DwOrderInfo;

class DwOrderDAO extends DwDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function getOrderInfo($orderId){

    $this->logger->info(__METHOD__."BEGIN");

    $orderHeaderQuery = "select * from dem_order_header doh inner join dem_price_adjustments dpa on (dpa.resp_table_record_id = doh.order_header_id and dpa.table_name = 'dem_order_header') where doh.original_order_no = '".$orderId."'";
    $this->logger->debug("Get order-headers query : ".$orderHeaderQuery);
    $data = $this->getDbHandle()->query($orderHeaderQuery)->fetchAll();
    $this->logger->debug("Result :   ".print_r($data,true));

    if (empty($data)){
      $this->logger->debug("No info found for the given orderId ".$orderId);
      return null;
    }
    $dwOrder = new DwOrderInfo();
    
    $dwOrder->setOrderGrossPrice($data[0]["order_gross_price"]);
    

    $this->logger->debug("Order gross price in dw =  :   ".$data[0]["order_gross_price"]);
    

    $this->logger->info(__METHOD__."END");

    return $dwOrder;


  }

}
