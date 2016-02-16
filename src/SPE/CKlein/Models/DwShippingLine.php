<?php


namespace SPE\CKlein\Models;

/*
Class that holds values of all fields found in the revenue report
related to a order-line. 
*/
class DwShippingLine {

  private $productId;
  private $netPrice;
  private $tax;
  private $grossPrice;
  private $basePrice;
  private $lineItemText;
  private $qty;
  private $promotionId;
  private $promoNetPrice=0;
  private $promoTax=0;
  private $promoGrossPrice=0;
  private $promoBasePrice=0;

  public function setLineItemText($lineItemText){
    $this->lineItemText=$lineItemText;
  } 

  public function getLineItemText(){
    return $this->lineItemText;
  } 

  public function setPromotionId($promotionId){
    return $this->promotionId=$promotionId;
  } 

  public function getPromotionId(){
    return $this->promotionId;
  } 

  public function setBasePrice($basePrice){
    $this->basePrice=$basePrice;
  } 

  public function setPromoBasePrice($promoBasePrice){
    $this->promoBasePrice=$promoBasePrice;
  } 

  public function getPromoBasePrice(){
    return $this->promoBasePrice;
  } 

  public function getAdjNetPrice(){
    //note promoNetPrice is in negative - should not substract
    return $this->netPrice+$this->promoNetPrice;
  }

  public function getAdjGrossPrice(){
    return $this->grossPrice+$this->promoGrossPrice;
  }

  public function getAdjTax(){
    return $this->tax+$this->promoTax;
  }

  public function getAdjBasePrice(){
    return $this->basePrice+$this->promoBasePrice;
  }

  public function setPromoNetPrice($promoNetPrice){
    $this->promoNetPrice=$promoNetPrice;
  } 

  public function getPromoNetPrice(){
    return $this->promoNetPrice;
  } 


  public function setPromoGrossPrice($promoGrossPrice){
    $this->promoGrossPrice=$promoGrossPrice;
  } 

  public function getPromoGrossPrice(){
    return $this->promoGrossPrice;
  } 

  public function setPromoTax($promoTax){
    $this->promoTax=$promoTax;
  } 

  public function getPromoTax(){
    return $this->promoTax;
  } 


  public function setGrossPrice($grossPrice){
    $this->grossPrice=$grossPrice;
  } 

  public function getGrossPrice(){
    return $this->grossPrice;
  } 

  public function setTax($tax){
    $this->tax=$tax;
  } 

  public function getTax(){
    return $this->tax;
  } 

  public function setProductId($productId){
    $this->productId=ltrim($productId,'0');
  } 

  public function setQty($qty){
    $this->qty=$qty;
  } 

  public function setNetPrice($netPrice){
    $this->netPrice=$netPrice;
  } 

  public function getProductId(){
    return $this->productId;
  } 

  public function getQty(){
    return $this->qty;
  } 

  public function getNetPrice(){
    return $this->netPrice;
  } 

}
