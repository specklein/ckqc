<?php

namespace SPE\CKlein\Reports;

use SPE\Core\QCConfig;
use SPE\Core\QCLogger;
use SPE\CKlein\DAO\Orders\ConsolidatedReportDAO;
use SPE\CKlein\Utils\RevenueReportUtils;
use SPE\Core\Payment\Transaction;
use SPE\CKlein\Mappers\ConsolidatedReportOrders2Array;
use Exception;
use SPE\Core\Document\OfficeExcelFactory;
use SPE\Core\Models\MailMessage;
use SPE\Ext\PHPMailerProxy;

class  ConsolidatedReport {

  private $logger;
  private $config;

  private $revenueOrder;
  private $dwOrderInfo;
  private $cybersourceOrderInfo;
  private $wmsShipmentInfo;

  private $orderIdsArray;

  private $templateReportSheet;
  private $reportsFolder;
  private $reportsFilename;
  private $reportsRecipients;


  public function __construct(){
    $this->logger = QCLogger::getInstance();
    $this->config = QCConfig::getInstance();
    $this->templateReportSheet = APPLICATION_ROOT_FOLDER.'/'.$this->config->get('reports')['cklein.consolidated.report.tempate.file'];
    $this->reportsFolder = $this->config->get("reports")["cklien.consolidated.reports.folder"];
    $this->reportsFilename = $this->config->get('reports')["cklien.consolidated.reports.filename"];
    $this->reportsRecipients = $this->config->get('reports')["cklien.consolidated.reports.recipients.csv"];
  }

  public function setDwOrderInfo($dwOrderInfo){
    $this->dwOrderInfo = $dwOrderInfo;
  }

  public function setCybersourceOrderInfo($cybersourceOrderInfo){
    $this->cybersourceOrderInfo =  $cybersourceOrderInfo;
  }

  public function setWmsShipmentInfo($wmsShipmentInfo){
    $this->wmsShipmentInfo =  $wmsShipmentInfo;
  }

  public function getConsolidatedOrderInfoArray(){
    if (! $revenueOrder && $dwOrderInfo && $cybersourceOrderInfo && $wmsShipmentInfo){
       throw new Exception("Object not constructed properly ");
    }
  }

  public function generate($revenueReportFile){
    //get Revenue Model object

    $revenueReportModel = RevenueReportUtils::getRevenueModel($revenueReportFile);
    //get Cybersource data for each order
    $csTxnInfoArray = Transaction::getCyberSourceTxnSummary($revenueReportModel);

    //get Dw, WMS, Suplizer data from Db
    $dbData = $this->getDbData(array_keys($revenueReportModel->getOrders()));


    $reportDataArray=ConsolidatedReportOrders2Array::getReportDataInArray($dbData,$revenueReportModel, $csTxnInfoArray);
    $this->logger->debug("reportData".print_r($reportDataArray,true));
    $reportFile = $this->reportsFolder."/".$this->reportsFilename;
    //$reportFile = $this->reportsFilename;
    $this->logger->debug("Report filename = ".$reportFile);
    $consolidateReportFile = (new OfficeExcelFactory())->createDocument($this->templateReportSheet,$reportFile, "0",$reportDataArray,"A3");
    $this->logger->debug("Report file generated ".$reportFile);
    $this->emailReport($reportFile);
    
  }

  public function emailReport($reportFile){

    $mail = new MailMessage();
    $mail->addTo($this->reportsRecipients);
    //$mail->setFrom("noreply@specom.io");
    $mail->setSubject("ConsolidatedReport ");
    $mail->setBody("Consolidated Report !!!");
    $mail->addAttachment($reportFile,"application/vnd.ms-excel");


    $mailer = new PHPMailerProxy();
    $mailer->send($mail);

    

  }

  private function getDbData($orderIdsArray){

    $consolidatedReportDAO = new ConsolidatedReportDAO();
    $dbData = $consolidatedReportDAO->getOrderSummary($orderIdsArray);
    if (!$dbData ){
      $ex = new Exception ("Could not get data from db for the given orderIds");
      $this->logger->debug("Could not get data from db for the orderIds".print_r($orderIdsArray,true));
      throw $ex;
    }
    return $dbData;
   
    
  }


/*
  private function getCyberSourceData($revenueReportModel){
    $csTxnInfoArray = array();
    foreach ($revenueReportModel->getOrders() as $revenueOrder){
      $orderId = $revenueOrder[0]->getOrderId();
      //this is just for testing...don't want to do this for all orders
      if ($orderId != 'CKHD00006007'){
        continue;
      }else{
      }
      $revOrderDate = date_create($revenueOrder[0]->getOrderDate());
      $revOrderDateFormatted = date_format($revOrderDate,'Ymd');
      $csTxnInfo = Transaction::getCyberSourceTxnInfo($orderId, $revOrderDateFormatted);
      $csTxnInfoArray[$orderId] = $csTxnInfo;
    }
    return $csTxnInfoArray;

  }
*/

}
