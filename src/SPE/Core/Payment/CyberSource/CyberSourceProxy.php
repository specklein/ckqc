<?php

namespace SPE\Core\Payment\CyberSource;

use SPE\Core\Payment\CyberSource\CSConfigKey;
use GuzzleHttp\Client;
use SPE\Core\QCLogger;
use SPE\Core\QCConfig;

class CyberSourceProxy {

  private $logger;
  private $config;
  private $csEndpoint;
  private $csUsername;
  private $csPassword;
  private $csQueryPath;
  private $csMerchantID;
  private $type = 'transaction';
  private $subtype = 'transactionDetail';
  private $version = '1.9';
 
  public function __construct(){
    $this->logger = QCLogger::getInstance();
    $this->config = QCConfig::getInstance();
    $csConfig = $this->config->get('cybersource');
    $this->csEndpoint = $csConfig[CSConfigKey::ONDEMAND_REQ_ENDPOINT];
    $this->csUsername = $csConfig[CSConfigKey::ONDEMAND_REQ_USERNAME];
    $this->csPassword = $csConfig[CSConfigKey::ONDEMAND_REQ_PASSWORD];
    $this->csQueryPath = $csConfig[CSConfigKey::ONDEMAND_QUERY_PATH];
    $this->csMerchantID = $csConfig[CSConfigKey::ONDEMAND_REQ_MERCHANTID];
  }

  public function getTransactionDetailsXml($merchantReferenceNumber,$targetDate){
    $this->logger->info("BEGIN ".__METHOD__);
    $csClient = new Client();
    $response = $csClient->request('POST', $this->csEndpoint.$this->csQueryPath,[
      'auth' => [$this->csUsername, $this->csPassword],
      'form_params' => [
        'merchantID' => $this->csMerchantID,
        'type' => $this->type,
        'subtype' => $this->subtype,
        'requestID' => '',
        'merchantReferenceNumber' => $merchantReferenceNumber,
        'targetDate' => $targetDate,
        'versionNumber' => $this->version
      ]
    ]);
    $this->logger->debug("Response from Cybersource ".print_r($response,true));
    $this->logger->debug("Response status code ".$response->getStatusCode());
    $this->logger->debug("Response body ".(string)$response->getBody());
    $this->logger->info("END ".__METHOD__);
    if ( !empty( $response->getBody())){
      $this->logger->debug("Response body ".(string)$response->getBody());
      return (string)$response->getBody();
    }
    $this->logger->error("Error: invalid response from CyberSource");
    return null;

  }

}
