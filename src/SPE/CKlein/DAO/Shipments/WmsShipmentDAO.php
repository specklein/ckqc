<?php


namespace SPE\CKlein\DAO\Shipments;

use SPE\CKlein\DAO\Shipments\WmsDbAbstract;

class WmsShipmentDAO extends WmsDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function getShipmentInfo($orderNumber){
   $this->logger->info("About to get shipment info for order number ".$orderNumber);
   $shipmentQuery = "select * from ext_wms_shipment_report ewsr where ewsr.customer_order_no = '".$orderNumber."'";

   $this->logger->debug("Get shipment info query : ".$shipmentQuery);
   $data = $this->getDbHandle()->query($shipmentQuery)->fetchAll();
   $this->logger->debug("Result :   ".print_r($data,true));
   return $data;
  }


}
