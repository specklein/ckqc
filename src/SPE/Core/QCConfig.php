<?php

namespace SPE\Core;

use Noodlehaus\Config;

class QCConfig {

  private static $qcConfig = null;

  private static $APP_CONFIG_FOLDER = '/etc/config';

  private static $credConfig  = null;

  //Making this class a singleton
  private function __construct(){ 
  }


  //In a multi-threaded env this may not work correctly
  //PHP being run in a single process - this will work
  public static function getInstance(){
    
    $APP_CONFIG_FILE = APPLICATION_ROOT_FOLDER.self::$APP_CONFIG_FOLDER.'/app.ini';
    if (self::$qcConfig) {
     return self::$qcConfig;
    } else {
      self::$qcConfig = new Config($APP_CONFIG_FILE);
    }
    return self::$qcConfig;

  }


  public static function getCredConfig(){

    if (!self::$credConfig){
      $qcConfig = self::getInstance();
      $credFile = $qcConfig->get('secure')['credentials.filepath'];
      self::$credConfig = new Config($credFile);
    }
    return self::$credConfig;

  }

}
