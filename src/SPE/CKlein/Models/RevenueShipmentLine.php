<?php


namespace SPE\CKlein\Models;

/*
Class that holds values of all fields found in the revenue report
related to a order-line. 
*/
class RevenueShipmentLine {

  private $gtin;
  private $price;
  private $qty;

  public function getGtin(){
    return $this->gtin;
  } 

  public function getQty(){
    return $this->qty;
  } 

  public function getPrice(){
    return $this->price;
  } 

  public function __construct($gtin, $price, $qty){
    $this->gtin= $gtin;
    $this->price=$price;
    $this->qty=$qty;
  }

}
