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

$revenueOrdersModel = RevenueCSV2Model::transform($csvRecords);

Registry::getInstance()->add('revOrdersModel',$revenueOrdersModel);

$database = new medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'supplizer_clarins_uat',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
 
	// [optional]
	'port' => 3306,
 
	// [optional] Table prefix
	'prefix' => '',
 
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
]);

$ordersFromDb = $database->query('select * from dem_order_header limit 2')->fetchAll();


