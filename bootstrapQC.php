<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/etc/config/config.php';

use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Mappers\RevenueCSV2Model;
use SPE\Core\Registry;

define('APPLICATION_PATH', realpath(dirname(__FILE__) ));

$revenueReport = new RevenueCSV('/home/cklein/revenue-reports/singpost20160118.csv');
$csvRecords = $revenueReport->getCsvRecords()->setOffset(1)->fetchAll();

Registry::getInstance()->add('csvRecords',$csvRecords);

$revenueReportModel = RevenueCSV2Model::transform($csvRecords);

Registry::getInstance()->add('revReportModel',$revenueReportModel);

