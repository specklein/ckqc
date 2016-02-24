<?php


use SPE\Core\QCLogger;
use SPE\Core\Registry;
use PHPUnit_Framework_BaseTestListener;

class BaseTestListener extends PHPUnit_Framework_BaseTestListener {

  private $logger;
  const FAILURE_TESTCASES_KEY = "failureTCs";

  public function __construct(){
  //  parent::__construct();
    $this->logger=QCLogger::getInstance();
  }

  private function __initBaseTC(){
    $failureTestCases = Registry::getInstance()->get(FAILURE_TESTCASES_KEY);
    if (! $failureTestCases){
      $failureTestCases = array();
      Registry::getInstance(FAILURE_TESTCASES_KEY,$failureTestCases);
    }
      
  }

  public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time){
    $this->logger->info("Test ". $test->getName()." failed");
    $failureTestCases = Registry::getInstance()->get(FAILURE_TESTCASES_KEY);
    $failreTestCases[]= $test;
  }

  public function startTestSuite(PHPUnit_Framework_TestSuite $suite){
    $this->__initBastTC();
    $this->logger->info("TestSuite '%s' started.\n", $suite->getName());
  }

  public function endTestSuite(PHPUnit_Framework_TestSuite $suite){
    $this->logger->info("TestSuite '%s' ended.\n", $suite->getName());
  }

}
