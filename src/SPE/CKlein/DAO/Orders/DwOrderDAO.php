<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\Core\QCConfigKey;
use SPE\CKlein\DAO\Orders\DwDbAbstract;
use SPE\CKlein\Models\DwOrderInfo;
use SPE\CKlein\Models\DwOrderLine;
use SPE\CKlein\Mappers\DbResult2DwOrderLine;
use SPE\CKlein\Mappers\DbResult2DwShippingLine;

class DwOrderDAO extends DwDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function getOrderInfo($orderId){

    $this->logger->info(__METHOD__."BEGIN");

    $orderHeaderQuery = "select doh.*, sum(dpa.net_price) as promo_net_price, sum(dpa.tax) as promo_tax, sum(dpa.gross_price) as promo_gross_price, sum(dpa.base_price) as promo_base_price from dem_order_header doh left join dem_price_adjustments dpa on (dpa.resp_table_record_id = doh.order_header_id and dpa.table_name = 'dem_order_header') where doh.original_order_no = '".$orderId."'";
    $this->logger->debug("Get order-headers query : ".$orderHeaderQuery);
    $data = $this->getDbHandle()->query($orderHeaderQuery)->fetchAll();
    $this->logger->debug("Result :   ".print_r($data,true));

    if (empty($data)){
      $this->logger->debug("No info found for the given orderId ".$orderId);
      return null;
    }
    $dwOrder = new DwOrderInfo();
    
    $dwOrder->setOrderGrossPrice($data[0]["order_gross_price"]);
    $dwOrder->setOrderPromoGrossPrice($data[0]["promo_gross_price"]);
    $dwOrder->setMerchantGrossPrice($data[0]["merc_gross_price"]);

    $orderLineQuery = "select dpil.*, dpa.net_price as promo_net_price, dpa.tax as promo_tax, dpa.gross_price as promo_gross_price, dpa.base_price as promo_base_price, dpa.promotion_id from dem_product_item_line dpil inner join dem_order_header doh on (doh.order_header_id = dpil.order_header_id) left join dem_price_adjustments dpa on (dpil.product_item_line_id = dpa.resp_table_record_id and dpa.table_name = 'dem_product_item_line') where doh.original_order_no ='".$orderId."'";
    
    $this->logger->debug("Get order-line query : ".$orderLineQuery);
    $orderLines = $this->getDbHandle()->query($orderLineQuery)->fetchAll();
    $this->logger->debug("Result :   ".print_r($orderLines,true));

    if (empty($orderLines) || count($orderLines) == 0){
     $this->logger->debug("No order lines found for the given orderId :".$orderId);
     return null;
    }

    foreach ($orderLines  as $orderLine){
      $this->logger->debug(" orderLine - ".print_r($orderLine,true));
      $dwOrderLine = DbResult2DwOrderLine::transform($orderLine);
      $dwOrder->addOrderLine($dwOrderLine);    
    }


    $shippingLineQuery = "SELECT dsil.*, dpa.net_price AS promo_net_price, dpa.tax AS promo_tax, dpa.gross_price AS promo_gross_price, dpa.base_price AS promo_base_price, dpa.promotion_id FROM dem_order_header doh LEFT JOIN dem_shipping_item_line dsil ON (doh.order_header_id = dsil.order_header_id) INNER JOIN dem_shipment ds on (ds.order_header_id = doh.order_header_id) LEFT JOIN dem_price_adjustments dpa ON (dsil.shipping_item_line_id = dpa.resp_table_record_id AND dpa.table_name = 'dem_shipping_item_line') where doh.original_order_no ='".$orderId."'";

    $this->logger->debug("Get shipping-line query : ".$shippingLineQuery);
    $shippingLines = $this->getDbHandle()->query($shippingLineQuery)->fetchAll();
    $this->logger->debug("Result :   ".print_r($shippingLines,true));

    if (empty($shippingLines) || count($shippingLines) == 0){
     $this->logger->debug("No shipping lines found for the given orderId :".$orderId);
     return null;
    }


    foreach ($shippingLines  as $shippingLine){
      $this->logger->debug(" shippingLine - ".print_r($shippingLine,true));
      $dwShippingLine = DbResult2DwShippingLine::transform($shippingLine);
      $dwOrder->addShippingLine($dwShippingLine);
    }


    $this->logger->debug("Order gross price in dw =  :   ".$data[0]["order_gross_price"]);
    

    $this->logger->info(__METHOD__."END");

    return $dwOrder;


  }

}
