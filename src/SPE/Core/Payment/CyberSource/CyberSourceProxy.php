<?php

namespace SPE\Core\Payment\CyberSource;

use SPE\Core\Payment\CyberSource\CSConfigKey;
use SPE\Core\QCConfigKey;
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

    $this->csQueryPath = $csConfig[CSConfigKey::ONDEMAND_QUERY_PATH];
    $this->csMerchantID = $csConfig[CSConfigKey::ONDEMAND_REQ_MERCHANTID];
    $this->csEndpoint = $csConfig[CSConfigKey::ONDEMAND_REQ_ENDPOINT];

    $credConfig = QCConfig::getCredConfig()->get(QCConfigKey::_CK_CREDENTIALS_CONFIG_SECTION);
    //$this->csUsername = $csConfig[CSConfigKey::ONDEMAND_REQ_USERNAME];
    //$this->csPassword = $credConfig[CSConfigKey::ONDEMAND_REQ_PASSWORD];
    $this->csUsername = $credConfig[CSConfigKey::ONDEMAND_REQ_USERNAME];
    $this->csPassword = $credConfig[CSConfigKey::ONDEMAND_REQ_PASSWORD];

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
