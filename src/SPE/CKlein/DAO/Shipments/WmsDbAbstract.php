<?php


namespace SPE\CKlein\DAO\Shipments;

use SPE\Core\QCConfigKey;
use SPE\Core\QCConfig;
use SPE\Core\QCDbAbstract;

class WmsDbAbstract extends QCDbAbstract {

  public function __construct(){
    parent::__construct();
  }

  public function setDbConfig(){

    //note wms shipment data is stored in supplizer
    //reusing same ordersdb config
    $ordersConfig = $this->config->get('ordersdb');
    $this->dbType=$ordersConfig[QCConfigKey::_ORDERS_DB_TYPE_CONFIG_KEY];
    $this->dbName=$ordersConfig[QCConfigKey::_ORDERS_DB_NAME_CONFIG_KEY];
    $this->dbServer=$ordersConfig[QCConfigKey::_ORDERS_DB_SERVER_CONFIG_KEY];
    $this->dbCharset=$ordersConfig[QCConfigKey::_ORDERS_DB_CHARSET_CONFIG_KEY];
    $this->dbPort=$ordersConfig[QCConfigKey::_ORDERS_DB_PORT_CONFIG_KEY];
   
    //all cred are stored in a separate cred file
    $credConfig = QCConfig::getCredConfig();
    $ckCredConfig = $credConfig->get(QCConfigKey::_CK_CREDENTIALS_CONFIG_SECTION);
    $this->dbUsername=$ckCredConfig[QCConfigKey::_ORDERS_DB_USERNAME_CONFIG_KEY];
    $this->dbPassword=$ckCredConfig[QCConfigKey::_ORDERS_DB_PASSWORD_CONFIG_KEY];
  }

}
