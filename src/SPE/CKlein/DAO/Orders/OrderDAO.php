<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\Core\QCConfig;
use SPE\Core\QCLogger;
use SPE\Core\QCConfigKey;
use SPE\Core\QCDbAbstract;

class OrderDAO extends QCDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function setDbConfig(){
    $ordersConfig = $this->config->get('ordersdb');
    $this->dbType=$ordersConfig[QCConfigKey::_ORDERS_DB_TYPE_CONFIG_KEY];
    $this->dbName=$ordersConfig[QCConfigKey::_ORDERS_DB_NAME_CONFIG_KEY];
    $this->dbServer=$ordersConfig[QCConfigKey::_ORDERS_DB_SERVER_CONFIG_KEY];
    $this->dbUsername=$ordersConfig[QCConfigKey::_ORDERS_DB_USERNAME_CONFIG_KEY];
    $this->dbPassword=$ordersConfig[QCConfigKey::_ORDERS_DB_PASSWORD_CONFIG_KEY];
    $this->dbCharset=$ordersConfig[QCConfigKey::_ORDERS_DB_CHARSET_CONFIG_KEY];
    $this->dbPort=$ordersConfig[QCConfigKey::_ORDERS_DB_PORT_CONFIG_KEY];
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

}
