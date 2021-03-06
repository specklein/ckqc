<?php

namespace SPE\Ext;

use SPE\Core\QCLogger;
use SPE\Core\QCConfig;
use PHPMailer;
use Exception;

class PHPMailerProxy {

  private $logger;
  private $mailClient;
  private $config;
  private $debugSendEmail=false;
  private $debugSendEmailConfigKey = "cklein.consolidated.report.email.debug";

  public function __construct(){

    $this->logger = QCLogger::getInstance();
    $this->config = QCConfig::getInstance();
    $this->setupMailClient();

  }


  private function setupMailClient(){
    $aws = $this->config->get('aws');
    $credConfig = QCConfig::getCredConfig();
    if (!$credConfig) {
      throw new Exception("Missing AWS credentials file");
    }
    $this->mailClient = new PHPMailer();
    $this->mailClient->isSMTP();
    $this->mailClient->SMTPAuth = true;
    $this->debugSendEmail = $this->config->get('logs')[$this->debugSendEmailConfigKey];
    if ($this->debugSendEmail){
      $this->mailClient->SMTPDebug = 2;
    }
    $this->mailClient->SMTPSecure = 'tls';
    $this->mailClient->Host = $aws['cklein.qc.aws.ses.host'];
    $this->mailClient->Port = $aws['cklein.qc.aws.ses.port'];
    $this->mailClient->setFrom("noreply@specom.io");
    $this->mailClient->FromName="Operations SP-eCommerce";
    $profile = $aws['cklein.qc.aws.ses.profile'];
    $this->mailClient->Username = $credConfig->get($profile)['aws_access_key_id'];
    $this->mailClient->Password = $credConfig->get($profile)['aws_secret_access_key'];
  }



  public function send($message){
    $this->logger->debug("about to call sendEmail with message :".print_r($message,true));
    if ($message->isMessageInHtml()){
      $this->mailClient->MsgHtml($message->getBody());
    }else {
      $this->mailClient->Body = $message->getBody();
    }
    $this->mailClient->Subject = $message->getSubject();
    $toRecipients = str_getcsv($message->getToCsv(),',');
    foreach($toRecipients as $toRecipient){
      if ($toRecipient) {
        $this->mailClient->addAddress($toRecipient);
      }
    }
    $attachments=$message->getAttachments();
    if (isset($attachments)){
      foreach($attachments as $attachment){
        $this->logger->debug("adding attachment to mail ".print_r($attachment,true));
        $this->mailClient->addAttachment($attachment['filepath']);
      }
    }
    $this->logger->debug("mailClient ".print_r($this->mailClient,true));
    if (! $this->mailClient->send()){
      $this->logger->error("Could not send email");
    }else{
      $this->logger->info("Mail sent successfully");
    }
  }

}
