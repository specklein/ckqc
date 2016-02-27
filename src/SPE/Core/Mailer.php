<?php

namespace SPE\Core;

use SPE\Core\QCLogger;
use SPE\Core\Models\MailMessage;
use SPE\Ext\PHPMailerProxy;

class Mailer {

  private $logger;

  public function __construct(){
    $this->logger = QCLogger::getInstance();
  }

  public function send(MailMessage $mail){
    $this->logger->info("Begin ".__Method__);
    $mailer = new PHPMailerProxy();
    $mailer->send($mail);
    $this->logger->info("End ".__Method__);
  }


}
