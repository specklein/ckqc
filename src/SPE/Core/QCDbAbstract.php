<?php

namespace SPE\Core;

use SPE\Core\QCConfig;
use SPE\Core\QCLogger;
use Exception;
use medoo;
use PDO;

abstract class QCDbAbstract {
  
  private $dbHandle;
  protected $config;
  protected $logger;

  public $dbType;
  public $dbName;
  public $dbServer;
  public $dbUsername;
  public $dbPassword;
  public $dbCharset;
  public $dbPort;


  public function __construct(){

    $this->config = QCConfig::getInstance();
    $this->logger = QCLogger::getInstance();

    $this->logger->info('Constructing meedoo db connection object');


  }

  /*
  * Set $dbType, $dbName, $dbServer, $dbUsername, $dbPassword, $dbCharset, $dbPort
  */
  abstract protected function setDbConfig();


  protected function getDbHandle(){
    $this->setDbConfig();
    $this->checkDbConfig();
    //if checkDbConfig is passed then 
    //db-connection can be tried
    $this->createDbHandle();
    return $this->dbHandle;


  }

  private function createDbHandle(){

    $this->dbHandle  =  new medoo([
        // required
        'database_type' => $this->dbType,
        'database_name' => $this->dbName,
        'server' => $this->dbServer,
        'username' => $this->dbUsername,
        'password' => $this->dbPassword,
        'charset' => $this->dbCharset,

        // [optional]
        'port' => $this->dbPort,

        // [optional] Table prefix
        'prefix' => '',

        // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
        'option' => [
                PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
  }

  private function checkDbConfig(){
    if (!isset($this->dbType)) {
      throw new Exception('dbType is not set ');
    }
    if (!isset($this->dbName)) {
      throw new Exception('dbName is not set ');
    }
    if (!isset($this->dbServer)) {
      throw new Exception('dbServer is not set ');
    }
    if (!isset($this->dbUsername)) {
      throw new Exception('dbUsername is not set ');
    }
    if (!isset($this->dbPassword)) {
      throw new Exception('dbPassword is not set ');
    }
    if (!isset($this->dbCharset)) {
      throw new Exception('dbCharset is not set ');
    }
    if (!isset($this->dbPort)) {
      throw new Exception('dbPort is not set ');
    }
  }


}
