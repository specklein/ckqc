<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\CKlein\DAO\Orders\DwDbAbstract;

class ConsolidatedReportDAO extends DwDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function getOrderSummary($orderIdsArray){
    
    $this->logger->info("About to get order-summary" );
    $orderIdsCsv = "('".implode("','",$orderIdsArray)."')";
    $query = "select dw.*, sum(olsm.qty_shipped) as totalQtyShipped, group_concat(ol.state) as sOrderStatus, ws.customer_order_number as wmsOrderNumber, ws.shipped_date as wmsShippedDate, ws.shipped_qty  as wmsShippedQty, ws.tracking_number as wmsTrackingNumber from order_header oh, order_header_external_id_map oheim, order_line ol, order_line_shipment_map olsm, (select  dem.original_order_no as dwOriginalOrderNumber,  dem.order_date as dwOrderDate, dem.order_gross_price as dwOrderGrossPrice, sum(dpil.quantity) as dwTotalOrderedQty from dem_order_header dem, dem_product_item_line dpil where dem.order_header_id = dpil.order_header_id and dem.original_order_no in ".$orderIdsCsv. " group by dem.order_header_id) dw, wms_shipment ws where oh.order_header_id = oheim.order_header_id and ol.order_header_id = oh.order_header_id and olsm.order_line_id = ol.order_line_id and binary dw.dwOriginalOrderNumber = binary oheim.external_order_number and ws.customer_order_number = dw.dwOriginalOrderNumber group by oh.order_header_id order by oh.order_header_id desc ";
    $this->logger->debug("Get order-summary query : ".$query);
    $data = $this->getDbHandle()->query($query)->fetchAll();
    $this->logger->debug("Result :   ".print_r($data,true));
    return $data;
  }

}
