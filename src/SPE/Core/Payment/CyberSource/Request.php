<?php

namespace SPE\Core\Payment\CyberSource;

use SimpleXMLElement;
use SPE\Core\QCLogger;
use Exception;

class Request {

  private $requestXmlElement;
  private $paymentAmountXPath = "/cs:Report/cs:Requests/cs:Request[@MerchantReferenceNumber='?']/cs:PaymentData/cs:Amount";
  private $logger;
  

  public function __construct($paymentRequestXml){
    if (! $paymentRequestXml){
      throw new Exception("Invalid request xml : ".print_r($paymentRequestXml,true));
    }
    $this->requestXmlElement = new SimpleXMLElement($paymentRequestXml);
    //$this->requestXmlElement = simplexml_load_file ("/tmp/csRequest.xml");
    $this->requestXmlElement->registerXPathNamespace('cs',"https://ebctest.cybersource.com/ebctest/reports/dtd/tdr_1_9.dtd");
    $this->logger=QCLogger::getInstance();
  }

  public function getPaymentAmount($merchantReferenceNumber){
    if (! $this->requestXmlElement ){
      throw new Exception("Object not constructed properly - payment request XMl is not initialized");
    }
    if (! $merchantReferenceNumber){
      throw new Exception("Expecting not-null merchantReferenceNumber as argument ");
    }
    $paymentAmountNodesXPath = str_replace('?',$merchantReferenceNumber,$this->paymentAmountXPath);
    $this->logger->debug("XPath to be queried = ".$paymentAmountNodesXPath);
    $paymentAmountNodes = $this->requestXmlElement->xpath($paymentAmountNodesXPath);
    if (! $paymentAmountNodes ){
      $this->logger->debug("Eval = ".print_r($paymentAmountNodes,true));
      $this->logger->debug("Payment amount not found for the merchantReferenceNumber :".$merchantReferenceNumber);
      return null;
    }
    $this->logger->debug("Evaluated nodes ".print_r($paymentAmountNodes,true));
    //assuming there is only one paymentData returned
    return (string)$paymentAmountNodes[0];	
  }

}
