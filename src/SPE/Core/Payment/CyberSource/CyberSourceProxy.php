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
 
  private $dummyXml = '<!DOCTYPE Report SYSTEM "https://ebctest.cybersource.com/ebctest/reports/dtd/tdr_1_9.dtd">
<Report xmlns="https://ebctest.cybersource.com/ebctest/reports/dtd/tdr_1_9.dtd" Name="Transaction Detail" Version="1.9" MerchantID="calvinklein_hk" ReportStartDate="2016-02-28 17:52:58.467+00:00" ReportEndDate="2016-02-28 17:52:58.467+00:00">
  <Requests>
    <Request MerchantReferenceNumber="CKHD00006007" RequestDate="2016-02-19T06:41:06+00:00" RequestID="4558640658816410902020" SubscriptionID="" Source="SOAP Toolkit API" TransactionReferenceNumber="520534303800008761">
      <BillTo>
        <FirstName>DINESH KUMAR</FirstName>
        <LastName>DURAISAMY</LastName>
        <Address1># 1012,. St., Pererrru, ##0001</Address1>
        <Address2>MMalaysia</Address2>
        <City>HKKong</City>
        <State>Discovery Bay</State>
        <Zip>N/A</Zip>
        <Email>mytestmail1011@gmail.com</Email>
        <Country>HK</Country>
        <Phone>9600052452</Phone>
        <IPAddress>42.99.149.165</IPAddress>
      </BillTo>
      <ShipTo>
        <FirstName>DINESH KUMAR</FirstName>
        <LastName>DURAISAMY</LastName>
        <Address1># 1012,. St., Pererrru, ##0001</Address1>
        <Address2>MMalaysia</Address2>
        <City>HKKong</City>
        <State>Discovery Bay</State>
        <Country>HK</Country>
        <Phone>9600052452</Phone>
      </ShipTo>
      <PaymentMethod>
        <Card>
          <AccountSuffix>1111</AccountSuffix>
          <ExpirationMonth>5</ExpirationMonth>
          <ExpirationYear>2023</ExpirationYear>
          <CardType>Visa</CardType>
        </Card>
      </PaymentMethod>
      <LineItems>
        <LineItem Number="0">
          <FulfillmentType />
          <Quantity>1</Quantity>
          <UnitPrice>723.30</UnitPrice>
          <TaxAmount>0.00</TaxAmount>
          <MerchantProductSKU>701549824835</MerchantProductSKU>
          <ProductName>GREDO CHINO PANTS</ProductName>
          <ProductCode>default</ProductCode>
        </LineItem>
        <LineItem Number="1">
          <FulfillmentType />
          <Quantity>3</Quantity>
          <UnitPrice>2169.91</UnitPrice>
          <TaxAmount>0.00</TaxAmount>
          <MerchantProductSKU>701549841788</MerchantProductSKU>
          <ProductName>GREDO CHINO PANTS</ProductName>
          <ProductCode>default</ProductCode>
        </LineItem>

        <LineItem Number="2">
          <FulfillmentType />
          <Quantity>2</Quantity>
          <UnitPrice>1050.00</UnitPrice>
          <TaxAmount>0.00</TaxAmount>
          <MerchantProductSKU>701549753289</MerchantProductSKU>
          <ProductName>DEBOSSED CALVIN LOGO T-SHIRT</ProductName>
          <ProductCode>default</ProductCode>
        </LineItem>
        <LineItem Number="3">
          <FulfillmentType />
          <Quantity>1</Quantity>
          <UnitPrice>50.00</UnitPrice>
          <TaxAmount>0.00</TaxAmount>
          <MerchantProductSKU>STANDARD_SHIPPING</MerchantProductSKU>
          <ProductName>STANDARD_SHIPPING</ProductName>
          <ProductCode>STANDARD_SHIPPING</ProductCode>
        </LineItem>
      </LineItems>
      <ApplicationReplies>
        <ApplicationReply Name="ics_auth">
          <RCode>1</RCode>
          <RFlag>SOK</RFlag>
          <RMsg>Request was processed successfully.</RMsg>
        </ApplicationReply>
      </ApplicationReplies>
      <PaymentData>
        <PaymentRequestID>4558640658816410902020</PaymentRequestID>
        <PaymentProcessor>migs</PaymentProcessor>
        <Amount>3993.21</Amount>
        <CurrencyCode>HKD</CurrencyCode>
        <TotalTaxAmount>0.00</TotalTaxAmount>
        <AuthorizationCode>ABC12345</AuthorizationCode>
        <AVSResultMapped>2</AVSResultMapped>
        <CVResult>2</CVResult>
        <RequestedAmount>3993.21</RequestedAmount>
        <RequestedAmountCurrencyCode>HKD</RequestedAmountCurrencyCode>
      </PaymentData>
    </Request>
  </Requests>
</Report>
                                                           ';
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
/*
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
*/
   return $this->dummyXml;

  }



}
