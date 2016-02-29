<?php

namespace SPE\Core\Document;

use PHPExcel_IOFactory;

class OfficeExcelFactory {

  public function __construct(){
  }

  public function createDocument($templateFile, $fileName, $activeSheetNum,  $arrayOfRecords, $startCell){

    $objTpl = PHPExcel_IOFactory::load($templateFile);
    
    $objTpl->setActiveSheetIndex($activeSheetNum);  //set first sheet as active

    $objTpl->getActiveSheet()->fromArray($arrayOfRecords,NULL, $startCell);
    $objWriter = PHPExcel_IOFactory::createWriter($objTpl,'Excel2007');
    $objWriter->save($fileName);
    return $fileName;

  }

}
