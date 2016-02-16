<?php

namespace SPE\CKlein\Mappers;

use SPE\CKlein\Models\DwShippingLine;
use SPE\Core\QCConfig;
use SPE\Core\QCConfigKey;


class DbResult2DwShippingLine {


  public static function transform($dbResultSetRow){
    $dwShippingLine  = new DwShippingLine();
    $shippingProductId = QCConfig::getInstance()->get('reports')[QCConfigKey::_REVENUE_REPORT_SHIPMENT_GTIN_CONFIG_KEY];
    $dwShippingLine->setProductId($shippingProductId);
    $dwShippingLine->setNetPrice($dbResultSetRow['net_price']);
    $dwShippingLine->setTax($dbResultSetRow['tax']);
    $dwShippingLine->setGrossPrice($dbResultSetRow['gross_price']);
    $dwShippingLine->setBasePrice($dbResultSetRow['base_price']);
    $dwShippingLine->setPromoNetPrice($dbResultSetRow['promo_net_price']);
    $dwShippingLine->setPromoTax($dbResultSetRow['promo_tax']);
    $dwShippingLine->setPromoGrossPrice($dbResultSetRow['promo_gross_price']);
    $dwShippingLine->setPromoBasePrice($dbResultSetRow['promo_base_price']);
    $dwShippingLine->setPromotionId($dbResultSetRow['promotion_id']);
    return $dwShippingLine;
  }

}
