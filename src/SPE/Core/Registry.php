<?php

namespace SPE\Core;

use SPE\Core\QCLogger;
use Exception;

class Registry {

  private static $objects ;
  private static $instance;
  private $logger;

  private function __construct(){
    $this->objects = new \ArrayObject();
    $this->logger = QCLogger::getInstance();
    $this->logger->debug("Constructing Registry instance");

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
    $this->objects->offsetSet($key,$object);
/*
    if( true === isset($this->objects[$key]) ) {
      $this->logger->error("Key ".$key. " already exists.".PHP_EOL);
      throw new Exception('The instance with key '.$key.' already exists in registry.');
    }

    if(!empty($key)) {
      $this->objects[ $key ] = $object;
      $this->logger->debug("Key ".$key. " added .".PHP_EOL);
    }
*/

  }

  public function isRegistered($key) {

    return array_key_exists($key, $this->objects);

  }

  public function get( $key ) {

    //if( false === isset( $this->objects[$key] ) ) {
    if (!$this->isRegistered($key)){
      $this->logger->error("Key ".$key." not found");
      throw new Exception('Invalid instance requested');
    }

    return $this->objects->offsetGet($key);

  }

  public function replace($key, $object) {
    if ($this->isRegistered($key)){
      $this->objects->offsetUnset($key);
    } 
    $this->add($key,$object);
  }

}
