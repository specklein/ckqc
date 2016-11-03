<?php

namespace SPE\CKlein\Utils;

use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;
use SPE\Core\QCLogger;
use FlorianWolters\Component\Core\StringUtils;

class ShipUtils {

  /* return an array of shipping gtins */
  public static function getAllShippingGtins(){
    $qcConfig=QCConfig::getInstance()->get('reports');
    $csvOfShipGtins=$qcConfig[QCConfigKey::_REVENUE_REPORT_SHIPMENT_GTINS_CONFIG_KEY];
    return StringUtils::split($csvOfShipGtins,',',0);
  }

  /* return -1 if $gtin is not a shipping item a positive value if it is */
  public static function isGtinShippingItem($gtin){
    $qcConfig=QCConfig::getInstance()->get('reports');
    $csvOfShipGtins=$qcConfig[QCConfigKey::_REVENUE_REPORT_SHIPMENT_GTINS_CONFIG_KEY];
    return StringUtils::indexOf($csvOfShipGtins,StringUtils::stripStart($gtin,'0')); 

  }

}
