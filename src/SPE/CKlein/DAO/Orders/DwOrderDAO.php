<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\Core\QCConfigKey;
use SPE\CKlein\DAO\Orders\DwDbAbstract;
use SPE\CKlein\Models\DwOrderInfo;
use SPE\CKlein\Models\DwOrderLine;
use SPE\CKlein\Mappers\DbResult2DwOrderLine;

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

    $orderLineQuery = "select dpil.*, dpa.net_price as promo_net_price, dpa.tax as promo_tax, dpa.gross_price as promo_gross_price, dpa.base_price as promo_base_price, dpa.promotion_id from dem_product_item_line dpil inner join dem_order_header doh on (doh.order_header_id = dpil.order_header_id) left join dem_price_adjustments dpa on (dpil.product_item_line_id = dpa.resp_table_record_id and dpa.table_name = 'dem_product_item_line') where doh.original_order_no ='".$orderId."'";
    
    $this->logger->debug("Get order-line query : ".$orderLineQuery);
    $orderLines = $this->getDbHandle()->query($orderLineQuery)->fetchAll();
    $this->logger->debug("Result :   ".print_r($orderLines,true));

    if (empty($orderLines) || count($orderLines) == 0){
     $this->logger->debug("No order lines found for the given orderId :",$orderId);
     return null;
    }

    foreach ($orderLines  as $orderLine){
      $this->logger->debug(" orderLine - ".print_r($orderLine,true));
      $dwOrderLine = DbResult2DwOrderLine::transform($orderLine);
      $dwOrder->addOrderLine($dwOrderLine);    
    }

    $this->logger->debug("Order gross price in dw =  :   ".$data[0]["order_gross_price"]);
    

    $this->logger->info(__METHOD__."END");

    return $dwOrder;


  }

}
