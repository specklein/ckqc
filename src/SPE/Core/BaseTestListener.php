<?php

namespace SPE\Core;

use SPE\Core\QCLogger;
use SPE\Core\Registry;
//use PHPUnit_Framework_BaseTestListener;

class BaseTestListener extends \PHPUnit_Framework_BaseTestListener {

  private $logger;
  const FAILURE_TESTCASES_KEY = "failureTCs";

  public function __construct(){
    $this->logger=QCLogger::getInstance();
  }

  private function __initBaseTC(){
    $this->logger->info("going to init test suites ");
    if (!Registry::getInstance()->isRegistered(self::FAILURE_TESTCASES_KEY)){
      $this->logger->debug("Test cases array not found in Registry - going to construct and add with key ".self::FAILURE_TESTCASES_KEY);
      Registry::getInstance()->add(self::FAILURE_TESTCASES_KEY,array());
    }
      
  }

  public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time){
    $this->logger->info("Test ". $test->getName()." failed");
    $failureTestCases = Registry::getInstance()->get(self::FAILURE_TESTCASES_KEY);
    array_push($failureTestCases,$test);
    Registry::getInstance()->replace(self::FAILURE_TESTCASES_KEY, $failureTestCases);
    $this->logger->info("Adding failed test ". $test->getName()." to the Registry ".print_r($failureTestCases,true));
    $this->logger->info("End ".__METHOD__);
  }

  public function startTestSuite(\PHPUnit_Framework_TestSuite $suite){
    $this->__initBaseTC();
    $this->logger->info("TestSuite ". $suite->getName() . " started");
  }

  public function endTestSuite(\PHPUnit_Framework_TestSuite $suite){
    $this->logger->info("TestSuite ". $suite->getName() . " ended");
    $this->logger->debug("No of test cases failed ".print_r(Registry::getInstance()->get(self::FAILURE_TESTCASES_KEY),true));
  }

  private function tcFailureCount(){
    $failureTestCases = Registry::getInstance()->get(self::FAILURE_TESTCASES_KEY);
    if ($failureTestCases){
      return count($failureTestCases);
    }else{
      return 0;
    }
  }


}
