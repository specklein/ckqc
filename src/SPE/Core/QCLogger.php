<?php

namespace SPE\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use SPE\Core\QCConfig;
use SPE\Core\PrintRLineFormatter;
use Monolog\Formatter\JsonFormatter;


class QCLogger {

  private static $qcLogger = null;
  private static $logFileKey = 'cklein.revenue.report.qc.log.file';
  private static $logLevel = 'cklein.revenue.report.qc.log.level';
  private static $loggerNamespace = 'cklein.revenue.report.qc.logger.namespace';

  //Making this class a singleton
  private function __construct($configPath) { 
  }


  //In a multi-threaded env this may not work correctly
  //PHP being run in a single process - this will work
  public static function getInstance(){

    $logFile = QCConfig::getInstance()->get('logs')[self::$logFileKey];
    $logLevel = self::getMonologLevel(QCConfig::getInstance()->get('logs')[self::$logLevel]);
    if (self::$qcLogger) {
     return self::$qcLogger;
    } else {
      self::$qcLogger = new Logger(QCConfig::getInstance()->get('logs')[self::$loggerNamespace]);
      $handler = new StreamHandler($logFile, $logLevel);
      $handler->setFormatter(new PrintRLineFormatter());
      //$handler->setFormatter(new JsonFormatter());
      self::$qcLogger->pushHandler($handler);
    }
    return self::$qcLogger;
  }


  public static function getMonologLevel($logLevel){
   if ($logLevel == 'DEBUG') return Logger::DEBUG;
   else if ($logLevel == 'INFO') return Logger::INFO;
   else if ($logLevel == 'WARN') return Logger::WARN;
   else if ($logLevel == 'ERROR') return Logger::ERROR;
   else if ($logLevel == 'CRITICAL') return Logger::CRITICAL;
   else if ($logLevel == 'EMERGENCY') return Logger::EMERGENCY;
   else return Logger::ERROR;
  }

}
