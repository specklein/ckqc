<?php

namespace SPE\CKlein\Utils;

use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;
use SPE\Core\QCLogger;
use FlorianWolters\Component\Core\StringUtils;
use DateTime;
use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Mappers\RevenueCSV2Model;
use Exception;

class RevenueReportUtils {

  const reportFileArgName="reportFile";

  const reportDateArgName="reportDate";

  private static function getReportFileNameFromDate($reportDate){
    $qcConfig=QCConfig::getInstance()->get('reports');
    $reportFileName =  $qcConfig[QCConfigKey::_REVENUE_REPORT_FOLDER ]."/".$reportDate."*".$qcConfig[QCConfigKey::_REVENUE_REPORT_FILENAME_INFIX]."*.".$qcConfig[QCConfigKey::_REVENUE_REPORT_FILENAME_EXT];
    QCLogger::getInstance()->debug("Computed reportsFilename using the input reportDate is ".$reportFileName);
    $reportFile = glob($reportFileName);
    if (count($reportFile) == 0){
      QCLogger::getInstance()->debug("No files found having name with the report date: ".$reportDate );
      throw new Exception("No files found having name with the report date: ".$reportDate );
    }
    if (count($reportFile) > 1){
      QCLogger::getInstance()->debug("Multiple filenames found having filename with reportDate ".$reportDate );
      QCLogger::getInstance()->debug("Filenames found are: ".print_r($reportFile));
      throw new Exception("Invalid arguments - multiple files found with name having reportDate ".$reportDate);
    }
    return $reportFile[0];
  }


  public static function getReportFileName($arguments){

    foreach($arguments as $arg){
      if (StringUtils::startsWith($arg,self::reportFileArgName)){
        $reportFileName=StringUtils::split($arg,'=',2)[1];
        QCLogger::getInstance()->debug(__METHOD__ . " report filename found in argument = ".$reportFileName);
        return $reportFileName;
      }
      if (StringUtils::startsWith($arg,self::reportDateArgName)){
        $reportFileName=self::getReportFileNameFromDate(StringUtils::split($arg,'=',2)[1]);
        QCLogger::getInstance()->debug(__METHOD__ . " report filename constructed out of the date provided in argument = ".$reportFileName);
        return $reportFileName;
      }
    }
    //will come to this code block if there are no arguments having report file details
    //will construct using current date time
    $reportFileName =  self::getReportFileNameFromDate(self::getTodaysDate()); 
    QCLogger::getInstance()->debug(__METHOD__ . " report filename constructed using current date = ".$reportFileName);
    return $reportFileName;
    

  }

  private static function getYdayDate(){
   $dateTime = new DateTime(date('d.m.Y',strtotime("-1 days")));
   $reportDate = $dateTime->format('Ymd');
   return $reportDate;
  }


   public static function getRevenueModel($revenueReportFile){

     $revenueReport = new RevenueCSV($revenueReportFile);
     $csvRecords = $revenueReport->getCsvRecords()->setOffset(1)->fetchAll();
     $revenueReportModel = RevenueCSV2Model::transform($csvRecords);
     return $revenueReportModel;
   }

   public static function getReportDate($arguments){

     foreach($arguments as $arg){
       if (StringUtils::startsWith($arg,self::reportDateArgName)){
         return StringUtils::split($arg,'=',2)[1];
       }

     }
     //return self::getYdayDate();
     return self::getTodaysDate();

   }

   private static function getTodaysDate(){
     $dateTime = new DateTime(date('d.m.Y'));
     $reportDate = $dateTime->format('Ymd');
     return $reportDate;
   }



}
