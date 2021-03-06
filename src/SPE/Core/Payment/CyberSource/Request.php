<?php

namespace SPE\Core\Payment\CyberSource;

use SimpleXMLElement;
use SPE\Core\QCLogger;
use Exception;
use SPE\Core\Models\CyberSourceTxnInfo;

class Request {

  private $requestXmlElement;
  private $paymentAmountXPath = "/cs:Report/cs:Requests/cs:Request[@MerchantReferenceNumber='?']/cs:PaymentData/cs:Amount";
  private $requestDateXPath = "/cs:Report/cs:Requests/cs:Request[@MerchantReferenceNumber='?']/@RequestDate";
  private $logger;
  

  public function __construct($paymentRequestXml){
    if (! $paymentRequestXml){
      throw new Exception("Invalid request xml : ".print_r($paymentRequestXml,true));
    }
    $this->requestXmlElement = new SimpleXMLElement($paymentRequestXml);
    //$this->requestXmlElement = simplexml_load_file ("/tmp/csRequest.xml");
    //$this->requestXmlElement->registerXPathNamespace('cs',"https://ebctest.cybersource.com/ebctest/reports/dtd/tdr_1_9.dtd");
    $this->requestXmlElement->registerXPathNamespace('cs',"https://ebc.cybersource.com/ebc/reports/dtd/tdr_1_9.dtd");
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


  public function getCyberSourceTxnInfo($merchantReferenceNumber){
    $requestDate = $this->getXPathValue($merchantReferenceNumber,$this->requestDateXPath);
    $this->logger->debug("CyberSource requestDate = ".$requestDate);
    $paymentAmount = $this->getXPathValue($merchantReferenceNumber, $this->paymentAmountXPath);
    $this->logger->debug("CyberSource payment amount = ".$paymentAmount);
    $csTxnInfo = new CyberSourceTxnInfo();
    $csTxnInfo->setRequestDate($requestDate);
    $csTxnInfo->setPaymentAmount($paymentAmount);
    return $csTxnInfo;
    
  }

  private function getXPathValue($merchantReferenceNumber,$xpath){
    if (! $this->requestXmlElement ){
      throw new Exception("Object not constructed properly - payment request XMl is not initialized");
    }
    if (! $merchantReferenceNumber){
      throw new Exception("Expecting not-null merchantReferenceNumber as argument ");
    }
    $nodesXPath = str_replace('?',$merchantReferenceNumber,$xpath);
    $this->logger->debug("XPath to be queried = ".$nodesXPath);
    $nodes = $this->requestXmlElement->xpath($nodesXPath);
    if (! $nodes ){
      $this->logger->debug("Eval = ".print_r($nodes,true));
      $this->logger->debug("XPATH ".$xpath." not found for the merchantReferenceNumber :".$merchantReferenceNumber);
      return null;
    }
    $this->logger->debug("Evaluated nodes ".print_r($nodes,true));
    //assuming there is only one node that is possible
    return (string)$nodes[0];

  }

}
