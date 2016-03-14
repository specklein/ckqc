<?php

namespace SPE\CKlein\Reports;

use League\Csv\Reader;
use SPE\Core\QCLogger;


class RevenueCSV {

  private $logger;
  private $csvRecords;

  public function __construct($revenueReportFilepath) {

    $this->logger=QCLogger::getInstance();
    $this->csvRecords = Reader::createFromPath($revenueReportFilepath);

  }

  public function getCsvRecords(){
    return $this->csvRecords;
  }


}

