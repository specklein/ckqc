<?php

namespace SPE\CKlein\Utils;

use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;
use SPE\Core\QCLogger;
use FlorianWolters\Component\Core\StringUtils;
use DateTime;

class RevenueReportUtils {

  const reportFileArgName="reportFile";

  const reportDateArgName="reportDate";

  private static function getReportFileNameFromDate($reportDate){
    $qcConfig=QCConfig::getInstance()->get('reports');
    $reportFileName =  $qcConfig[QCConfigKey::_REVENUE_REPORT_FOLDER ]."/".$qcConfig[QCConfigKey::_REVENUE_REPORT_FILENAME_PREFIX].$reportDate.".".$qcConfig[QCConfigKey::_REVENUE_REPORT_FILENAME_EXT];
    return $reportFileName;
  }


  public static function getReportFileName($arguments){

    foreach($arguments as $arg){
      if (StringUtils::startsWith($arg,self::reportFileArgName)){
        $reportFileName=StringUtils::split($arg,'=',2)[1];
        QCLogger::getInstance()->debug(__METHOD__ . " report filename found in argument = ".$reportFileName);
        return $reportFileName;
    //break;
      }
      if (StringUtils::startsWith($arg,self::reportDateArgName)){
        $reportFileName=self::getReportFileNameFromDate(StringUtils::split($arg,'=',2)[1]);
        QCLogger::getInstance()->debug(__METHOD__ . " report filename constructed out of the date provided in argument = ".$reportFileName);
        return $reportFileName;
    //break;
      }
    }
    //will come to this code block if there are no arguments having report file details
    //will construct using yday date time
    $reportFileName =  self::getReportFileNameFromDate(self::getYdayDate()); 
    QCLogger::getInstance()->debug(__METHOD__ . " report filename constructed using yday's date = ".$reportFileName);
    return $reportFileName;
    

  }

  private static function getYdayDate(){
   $dateTime = new DateTime(date('d.m.Y',strtotime("-1 days")));
   $reportDate = $dateTime->format('Ymd');
   return $reportDate;
  }


}
