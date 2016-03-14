<?php


use SPE\CKlein\Reports\ConsolidatedReport;
use SPE\CKlein\Utils\RevenueReportUtils;

require_once __DIR__ . '/vendor/autoload.php';



define('APPLICATION_ROOT_FOLDER', realpath(dirname(__FILE__) ));
global $argv, $argc;

$consolidatedReport = new ConsolidatedReport($argv);

$consolidatedReport->generate();

