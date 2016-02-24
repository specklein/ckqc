<?php

//require_once __DIR__ . '/../bootstrapQC.php';

use SPE\Core\BaseTestCase;
use SPE\Core\Registry;
use SPE\Core\QCLogger;
use SPE\CKlein\Models\RevenueReport;
use SPE\CKlein\DAO\Orders\DwOrderDAO;

class RevenueReportPriceTest extends BaseTestCase {

  private static $logger;
  private static $revenueOrdersModel;
  

  /**
  * 
  */
  public static function setUpSharedFixtures() {
   // self::$logger = QCLogger::getInstance();
   // self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');

    if (!isset(self::$logger)){
     self::$logger = QCLogger::getInstance();
    }
    self::$logger->info("BEGIN ". __METHOD__);
    if (!isset(self::$revenueOrdersModel)){
      self::$revenueOrdersModel = Registry::getInstance()->get('revReportModel');
      //if still its not set throw exception
      if (!isset(self::$revenueOrdersModel)){
        throw new Exception("Not bootstrapped properly. Missing revenueOrdersModel");
      }
    }
    self::$logger->debug("Revenue orders".PHP_EOL.print_r(self::$revenueOrdersModel->getOrders()));
    self::$logger->info("END ". __METHOD__);

  }


  public static function getOrders(){

    self::setUpSharedFixtures();

    return $revenueOrders = self::$revenueOrdersModel->getOrders();

  }

  /**
   * @dataProvider getOrders
   */
  public function testOrder($revenueOrder){

    $this->logger = QCLogger::getInstance();
    $this->logger->info("BEGIN ". __METHOD__);
    $this->logger->debug("Received Revenue Order :".print_r($revenueOrder,true));

    $orderId = $revenueOrder->getOrderId();
    $this->logger->info("Testing Order #".$orderId);
    $this->logger->info("Sum of all prices for this order # - present in the report = ".$revenueOrder->getSumOfLinePrice());
    $this->logger->info("Checking against the value in db");

    $dwOrderDAO = new DwOrderDAO();
    $dwOrderInfo = $dwOrderDAO->getOrderInfo($orderId);
    $dwOrderLineCount = $dwOrderInfo->getOrderLineCount();
    $dwPromoGrossPrice = $dwOrderInfo->getOrderPromoGrossPrice();
    $dwSumOfAllOrderLineQty = $dwOrderInfo->getSumOfAllOrderLineQty();
    $dwMerchantGrossPrice = $dwOrderInfo->getMerchantGrossPrice();
    $dwOrderLines=$dwOrderInfo->getOrderLines();
    $dwShippingLines=$dwOrderInfo->getShippingLines();
    $dwSumOfOrderLineGPPostLineAdj=$dwOrderInfo->getSumOfOrderLineGPPostLineAdj();

    $this->assertGreaterThan(0,$dwOrderLineCount,"Count of orderLines is not greater than 0 for orderId:".$orderId);

    $this->logger->debug("dwOrderLineCount = ".$dwOrderLineCount);
    $this->logger->debug("dwMerchantGrossPrice = ".$dwMerchantGrossPrice);
    $this->logger->debug("dwPromoGrossPrice = ".$dwPromoGrossPrice);
    $this->logger->debug("dwSumOfOrderLineGPPostLineAdj=  ".$dwSumOfOrderLineGPPostLineAdj);
    $this->logger->debug("dw-order-lines from db for order-id ".$orderId. " ".print_r($dwOrderLines,true));

    $this->assertEquals(false,empty($dwOrderInfo),"Order, ".$orderId.", is not found in db");
    $this->assertEquals($revenueOrder->getSumOfLinePrice(), $dwOrderInfo->getOrderGrossPrice(),"Sum of prices for order ".$orderId." in report is = ".$revenueOrder->getSumOfLinePrice(). ". It is not matching with the gross price value ".$dwOrderInfo->getOrderGrossPrice() ." found in db ");
    $revenueOrderLines = $revenueOrder->getOrderLines();
    foreach( $revenueOrderLines as $revenueOrderLine){
      $this->logger->info("Checking for orderLine : productId : ".$revenueOrderLine->getGtin());
      if ($revenueOrder->isLineRepeating($revenueOrderLine->getGtin())){
        $this->logger->debug("This orderLine is split " );
      }
      $revenueGtinTrimmed=ltrim($revenueOrderLine->getGtin(),'0');
      $revenueQty=$revenueOrderLine->getQty();
      $revenuePrice=round($revenueOrderLine->getPrice()*$revenueQty,2,PHP_ROUND_HALF_DOWN);
      $this->logger->debug("Revenue data for GTIN ".$revenueGtinTrimmed. ", Qty = ".$revenueQty.", Price = ".$revenuePrice);
      if (! isset($dwOrderLines[$revenueGtinTrimmed])){
        $this->logger->error("Revenue record having Gtin = ".$revenueGtinTrimmed." is not found as a order line for order ".$orderId);
	$this->assertEquals(true,false,"Revenue record having Gtin = ".$revenueGtinTrimmed." is not found as a order line for order ".$orderId);
      }
      $this->assertNotEmpty($dwOrderLines[$revenueGtinTrimmed],"Order Line having GTIN  - ".$revenueGtinTrimmed." is not found in the db");
      //each line adjusted by the line-promotion + order-promotion/total-order-line
      $dwOrderLineQty = $dwOrderLines[$revenueGtinTrimmed][0]->getQty();
      //compute the order level discount to be applied to this line
      $dwOrderLevelAdj = round(($dwOrderLines[$revenueGtinTrimmed][0]->getAdjGrossPrice()/$dwSumOfOrderLineGPPostLineAdj)*$dwPromoGrossPrice,2,PHP_ROUND_HALF_DOWN);
      $this->logger->debug("order level adjustment to be applied to this order-line = ".$dwOrderLevelAdj);
      $this->logger->debug("Order line quantity = ".$dwOrderLineQty);
      $this->logger->debug("Order-line adjusted GP =  ".$dwOrderLines[$revenueGtinTrimmed][0]->getAdjGrossPrice());
      if ($dwOrderLineQty > 1 ){
        //check if this discount can be distributed across all quantities EVENLY without loosing a cent
        //find the disc per quantity rounded to 2 decimal places
        $dwOrderLevelAdjPerQty = round($dwOrderLevelAdj / $dwOrderLineQty, 2, PHP_ROUND_HALF_DOWN);
        $this->logger->debug("Per qty adjustment amount = ".$dwOrderLevelAdjPerQty);
        //check to see if this discPerQty * Qty equals the discountComputer for this order-line
        //note that all adjustment/discount values are negative value (< 0 )
        $discrepancyInDiscount = round($dwOrderLevelAdjPerQty*$dwOrderLineQty, 2, PHP_ROUND_HALF_DOWN)-$dwOrderLevelAdj;
        $this->logger->debug("Discrepancy in discount".$discrepancyInDiscount);
        if ($discrepancyInDiscount != 0){
          //the order-line will be split into two records and the discrepancy should have been added one of the order-lines having quantity as 1
          //this item will be repeated in Revenue report, lets check 
          $this->assertTrue($revenueOrder->isLineRepeating($revenueOrderLine->getGtin()), 'Order line, having GTIN - '.$revenueGtinTrimmed.' is supposed to be split into two lines, which is not the case');
          $dwOrderLineBasePrice = $dwOrderLines[$revenueGtinTrimmed][0]->getBasePrice();
          $this->logger->debug("Order line base price = ".$dwOrderLineBasePrice);
          //split order-line promotion value proportionately
          $newOrderLinePromoAdj = round(($dwOrderLines[$revenueGtinTrimmed][0]->getPromoGrossPrice()*$revenueQty)/$dwOrderLineQty, 2, PHP_ROUND_HALF_DOWN);
          $this->logger->debug("Order line promo split into two = ".$newOrderLinePromoAdj);
          if ($revenueQty == 1){
            $dwOrderLineAdjPrice = $dwOrderLineBasePrice + $newOrderLinePromoAdj + round($dwOrderLevelAdjPerQty-$discrepancyInDiscount,2,PHP_ROUND_HALF_DOWN);
          }else {
            $dwOrderLineAdjPrice = $dwOrderLineBasePrice * ($dwOrderLineQty-1) + $newOrderLinePromoAdj + round($dwOrderLevelAdjPerQty*($dwOrderLineQty-1), 2, PHP_ROUND_HALF_DOWN);
          }
          $this->assertEquals($revenuePrice, $dwOrderLineAdjPrice, "Price in revenue file for GTIN ".$revenueGtinTrimmed." is not same as in db (".$dwOrderLineAdjPrice.")");
          continue;

        }
      }
      
      $this->logger->debug("order level discount computed for orderline:".$revenueGtinTrimmed." = ".$dwOrderLevelAdj);
      //$dwOrderLineGPRatio = round(($dwOrderLines[$revenueGtinTrimmed][0]->getAdjGrossPrice()/$dwMerchantGrossPrice),4);
      //$dwOrderLineGPRatio = $dwOrderLines[$revenueGtinTrimmed][0]->getAdjGrossPrice()/$dwSumOfOrderLineGPPostLineAdj; //$dwMerchantGrossPrice;
      //$this->logger->debug("orderLineRatio for orderline - ".$revenueGtinTrimmed."= ".$dwOrderLineGPRatio);
      //$adjPriceFromDb = $dwOrderLines[$revenueGtinTrimmed][0]->getAdjGrossPrice()+$dwOrderLineGPRatio * $dwPromoGrossPrice;
      $dwOrderLineAdjPrice = $dwOrderLines[$revenueGtinTrimmed][0]->getAdjGrossPrice() + $dwOrderLevelAdj;
      $this->logger->debug("Adjusted order line (computed from db) = ".$dwOrderLineAdjPrice);
      $this->assertEquals($revenuePrice, $dwOrderLineAdjPrice, "Price in revenue file for GTIN ".$revenueGtinTrimmed." is not same as in db (".$dwOrderLineAdjPrice.")");
      //$this->assertEquals($revenuePrice, $adjPriceFromDb, "Price in revenue file for GTIN ".$revenueGtinTrimmed." is not same as in db (".$adjPriceFromDb.")");
    }


    //test shipping line values
    $revenueShippingLines = $revenueOrder->getShipmentLines();

    $this->logger->debug("revenueShippingLines ".print_r($revenueShippingLines , true));
    foreach ($revenueShippingLines as $revenueShippingLine){
      $this->logger->info("Checking shipping line : product-Id :".$revenueShippingLine->getGtin());
      $shippingGtin = ltrim ($revenueShippingLine->getGtin(),'0');
      $shippingPrice = $revenueShippingLine->getPrice();
      $this->logger->debug("dw-order-lines from db for order-id ".$orderId. " ".print_r($dwShippingLines,true));
      if (! isset($dwShippingLines[$shippingGtin])){
        $this->logger->error("Revenue record having shipping Gtin = ".$shippingGtin." is not found as a order line for order ".$orderId);
        $this->assertEquals(true,false,"Revenue record having Gtin = ".$shippingGtin." is not found as a order line for order ".$orderId);
      }
      $this->assertNotEmpty($dwShippingLines[$shippingGtin],"Shipping Line having GTIN  - ".$shippingGtin." is not found in the db");
      $adjShippingPriceFromDb = $dwShippingLines[$shippingGtin][0]->getAdjGrossPrice();//+$dwPromoGrossPrice;
      $this->assertEquals($shippingPrice, $adjShippingPriceFromDb, "Shipping gross price (".$shippingPrice.") in revenue file for GTIN ".$shippingGtin." is not same as in db (".$adjShippingPriceFromDb.")");



    }
    
    $this->logger->info("END ". __METHOD__);


  }



}
