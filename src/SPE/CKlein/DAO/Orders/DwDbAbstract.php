<?php


namespace SPE\CKlein\DAO\Orders;

use SPE\Core\QCConfigKey;
use SPE\Core\QCDbAbstract;

class DwDbAbstract extends QCDbAbstract {

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

}
