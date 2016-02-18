<?php

namespace SPE\CKlein\Mappers;

use SPE\CKlein\Models\DwOrderLine;

class DbResult2DwOrderLine {


  public static function transform($dbResultSetRow){
    $dwOrderLine  = new DwOrderLine();
    $dwOrderLine->setProductId($dbResultSetRow['product_id']);
    $dwOrderLine->setQty($dbResultSetRow['quantity']);
    $dwOrderLine->setNetPrice($dbResultSetRow['net_price']);
    $dwOrderLine->setTax($dbResultSetRow['tax']);
    $dwOrderLine->setGrossPrice($dbResultSetRow['gross_price']);
    $dwOrderLine->setBasePrice($dbResultSetRow['base_price']);
    $dwOrderLine->setPromoNetPrice($dbResultSetRow['promo_net_price']);
    $dwOrderLine->setPromoTax($dbResultSetRow['promo_tax']);
    $dwOrderLine->setPromoGrossPrice($dbResultSetRow['promo_gross_price']);
    $dwOrderLine->setPromoBasePrice($dbResultSetRow['promo_base_price']);
    $dwOrderLine->setPromotionId($dbResultSetRow['promotion_id']);
    return $dwOrderLine;
  }

}
