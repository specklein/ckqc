<?php

namespace SPE\Core;

use SPE\Core\QCLogger;
use SPE\Core\Models\MailMessage;
use SPE\Core\Mailer;
use SPE\Core\Transform\TestResultTransformer;

class TestResultHandler {

  private $logger;
  private $config;

  public function __construct(){

    $this->logger = QCLogger::getInstance();
    $this->config = QCConfig::getInstance();
  }

  public function onFailure($failedTestCases){

    $testResultsConfig = $this->config->get('testresults');
    //in case of failures send an email to failure recipient
    
    $mail = new MailMessage();
    $mail->addTo($testResultsConfig['revenue.report.test.failure.email.recipients.csv']);//"venkat.v@quantiumsolutions.com");
    $mail->setSubject($testResultsConfig['revenue.report.test.failure.email.subject']);
    $mail->setFrom($testResultsConfig['revenue.report.test.result.email.from']);
   
    $testResultTransformer = new TestResultTransformer();
    $emailMsg = $testResultTransformer->getFailureHtmlEmailMsg($failedTestCases);
    $mail->setHtmlBody($emailMsg);
    //$mail->addAttachment("/tmp/ck-daily-sales.csv","csv");

    $mailer = new Mailer();
    $mailer->send($mail);

  }


  public function onError($errorTestcases){
    $testResultsConfig = $this->config->get('testresults');
    //in case of failures send an email to failure recipient

    $mail = new MailMessage();
    $mail->addTo($testResultsConfig['revenue.report.test.failure.email.recipients.csv']);//"venkat.v@quantiumsolutions.com");
    $mail->setSubject($testResultsConfig['revenue.report.test.failure.email.subject']);
    $mail->setFrom($testResultsConfig['revenue.report.test.result.email.from']);

    $testResultTransformer = new TestResultTransformer();
    $emailMsg = $testResultTransformer->getErrorHtmlEmailMsg($errorTestcases);
    $mail->setHtmlBody($emailMsg);
    //$mail->addAttachment("/tmp/ck-daily-sales.csv","csv");

    $mailer = new Mailer();
    $mailer->send($mail);

  }

  public function onSetupError($exception){
    $testResultsConfig = $this->config->get('testresults');
    //in case of failures send an email to failure recipient

    $mail = new MailMessage();
    $mail->addTo($testResultsConfig['revenue.report.test.failure.email.recipients.csv']);//"venkat.v@quantiumsolutions.com");
    $mail->setSubject($testResultsConfig['revenue.report.test.failure.email.subject']);
    $mail->setFrom($testResultsConfig['revenue.report.test.result.email.from']);

    $testResultTransformer = new TestResultTransformer();
    $emailMsg = $testResultTransformer->getSetupErrorHtmlEmailMsg($exception);
    $mail->setHtmlBody($emailMsg);

    $mailer = new Mailer();
    $mailer->send($mail);

  }
}
