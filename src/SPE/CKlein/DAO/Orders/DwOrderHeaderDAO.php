<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\Core\QCConfigKey;
use SPE\CKlein\DAO\Orders\DwDbAbstract;

class DwOrderHeaderDAO extends DwDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function getOrders(){
   $this->logger->info("About to get orders ");
   $data = $this->getDbHandle()->query('select * from dem_order_header limit 2')->fetchAll();
   $this->logger->debug("Retrieved orders ".print_r($data,true));
   return $data;
  }
  
  public function getOrdersCount($reportDate){

   $this->logger->info("About to get count for reportDate ".$reportDate);
   $cutoffDateTime = $reportDate.' '.$this->config->get('reports')[QCConfigKey::_REVENUE_REPORT_CUTOFF_HOUR_CONFIG_KEY].':00:00';
   $orderCountQuery = "select count(*) as orderCount from dem_order_header doh where doh.order_date >= '".$cutoffDateTime."' and doh.order_date < '".$cutoffDateTime."' + INTERVAL 24 HOUR";
   $this->logger->debug("Get order count query : ".$orderCountQuery);
   $data = $this->getDbHandle()->query($orderCountQuery)->fetchAll();
   $this->logger->debug("Result :   ".print_r($data,true));
   return $data;

  }

  public function getOrderHeaders($reportDate){
   $this->logger->info("About to get order-headers for reportDate ".$reportDate);
   $cutoffDateTime = $reportDate.' '.$this->config->get('reports')[QCConfigKey::_REVENUE_REPORT_CUTOFF_HOUR_CONFIG_KEY].':00:00';
   //$orderHeaderQuery = "select doh.order_header_id as orderHeaderId, doh.original_order_no as origOrderNo,doh.currency_code as currCode, doh.order_date as orderDate, doh.order_status as orderStatus,doh.shipping_status as shippingStatus, doh.confirmation_status as confirmStatus, doh.payment_status as paymentStatus from dem_order_header doh left join dem_price_adjustments dpa on dpa.resp_table_record_id = doh.order_header_id and dpa.table_name = 'dem_order_header' where doh.order_date >= '".$cutoffDateTime."' and doh.order_date < '".$cutoffDateTime."' + INTERVAL 24 HOUR";
   $orderHeaderQuery = "select * from dem_order_header doh left join dem_price_adjustments dpa on dpa.resp_table_record_id = doh.order_header_id and dpa.table_name = 'dem_order_header' where doh.order_date >= '".$cutoffDateTime."' and doh.order_date < '".$cutoffDateTime."' + INTERVAL 24 HOUR";
   $this->logger->debug("Get order-headers query : ".$orderHeaderQuery);
   $data = $this->getDbHandle()->query($orderHeaderQuery)->fetchAll();
   $this->logger->debug("Result :   ".print_r($data,true));
   return $data;
  }



}
