<?php


use SPE\CKlein\Reports\ConsolidatedReport;
use SPE\CKlein\Utils\RevenueReportUtils;

require_once __DIR__ . '/vendor/autoload.php';



define('APPLICATION_ROOT_FOLDER', realpath(dirname(__FILE__) ));
global $argv, $argc;

//get revenue report filename from arg
$revenueReportFile=RevenueReportUtils::getReportFileName($argv);

$consolidatedReport = new ConsolidatedReport();

$consolidatedReport->generate($revenueReportFile);

