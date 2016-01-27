<?php

class OrderContainerXml {
    
    private const $ORDER_ELEMENT_XPATH = '/orders/order';
    
    public function getOrders($file){
        
        $xml = simplexml_load_file($file);
        $orders = $xml-xpath(self::ORDER_ELEMENT_XPATH);
        return $orders;
    }
}