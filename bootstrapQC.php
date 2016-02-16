<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/etc/config/config.php';

use SPE\CKlein\Reports\RevenueCSV;
use SPE\CKlein\Utils\RevenueReportUtils;
use SPE\CKlein\Mappers\RevenueCSV2Model;
use SPE\Core\Registry;
use FlorianWolters\Component\Core\StringUtils;

define('APPLICATION_PATH', realpath(dirname(__FILE__) ));

global $argv, $argc;
$revenueReportFile=RevenueReportUtils::getReportFileName($argv);
$revenueReport = new RevenueCSV($revenueReportFile);
$csvRecords = $revenueReport->getCsvRecords()->setOffset(1)->fetchAll();


Registry::getInstance()->add('csvRecords',$csvRecords);

$revenueReportModel = RevenueCSV2Model::transform($csvRecords);

Registry::getInstance()->add('revReportModel',$revenueReportModel);

