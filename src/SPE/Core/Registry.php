<?php

namespace SPE\Core;

use SPE\Core\QCLogger;
use Exception;

class Registry {

  private $objects = array();
  private static $instance;
  private $logger;

  private function __construct(){

    $this->logger = QCLogger::getInstance();
    $this->logger->debug("Constructing Registry instnace");

  } 

  private function __clone(){
  }

  public static function getInstance() {

    if( !isset( self::$instance ) ) {
      self::$instance = new self();
    }
    return self::$instance;
  }


  public function add( $key, $object ) {

    $this->logger->debug("Going to add Key ".$key );
    if( true === isset($this->objects[$key]) ) {
      $this->logger->error("Key ".$key. " already exists.".PHP_EOL);
      throw new Exception('The instance with key '.$key.' already exists in registry.');
    }

    if(!empty($key)) {
      $this->objects[ $key ] = $object;
      $this->logger->debug("Key ".$key. " added .".PHP_EOL);
    }

  }

  public function get( $key ) {

//    echo 'objects'.print_r($this->objects,true);
    if( false === isset( $this->objects[$key] ) ) {
      $this->logger->error("Key ".$key." not found");
      throw new Exception('Invalid instance requested');
    }

    return $this->objects[ $key ];
  }

}
