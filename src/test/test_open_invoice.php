<?php

include './../../vendor/autoload.php';

use CoreOpenApi\Config\Config;
use InvoiceOpenApi\Api\InvoiceService;
use InvoiceOpenApi\Protocol\InvoiceClient;

//实例化一个配置类
$config    = include 'config.php';
$configObj = new Config($config);
$token     = 'd4776bbb-b08b-4268-9d07-a35631f6de0d';//'f0ba7209-ec18-4855-a661-3607f1fb3b81';//
$client    = new InvoiceClient($token, $configObj);
//使用config和token对象，实例化一个服务对象
$invoiceservice = new InvoiceService($client);


//token错误 array ( 'code' => 100007, 'message' => '错误的签名', 'subCode' => 500, 'subMessage' => '错误的签名', )
//token过期 array (    'code' => 100002,    'message' => 'token错误',    'subCode' => NULL,    'subMessage' => '',)
//$resp = $invoiceservice->getToken($config);
//var_export($resp);exit;
$vo = new InvoiceOpenApi\VO\OpenInvoiceRequestVO();
$vo->setDeviceType('0')->setSerialNo('cd200000005')->setInvoiceTypeCode('026')->setSellerTaxNo('91500000747150426A');
$vo->setDrawer('黄惠')->setChecker('邱亚琪')->setPayee('邱亚琪')->setInvoiceType('0');
$vo->setBuyerName('购买方名字')->setInvoiceTerminalCode('kpyuan002')->setInvoiceSpecialMark("00");
$vo->setTaxationMode('0')->setInvoiceListMark('0')->setRemarks('注释内容，没有什么');
$vo->setInvoiceTotalPrice('10')->setInvoiceTotalPriceTax('11.44')->setInvoiceTotalTax('1.44');
$detailList = [];
$goodsLineNo = 1;
$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
//$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1070508030000000000');
$detailVO->setGoodsName('葫芦娃222');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.17');
$detailVO->setGoodsTaxRate('0.17');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1030201030000000000');
$detailVO->setGoodsName('饼干');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.10');
$detailVO->setGoodsTaxRate('0.10');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1010502000000000000');
$detailVO->setGoodsName('淡水虾');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.11');
$detailVO->setGoodsTaxRate('0.11');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1010503000000000000');
$detailVO->setGoodsName('淡水蟹');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.11');
$detailVO->setGoodsTaxRate('0.11');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1010504000000000000');
$detailVO->setGoodsName('淡水贝类');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.11');
$detailVO->setGoodsTaxRate('0.11');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1030201020000000000');
$detailVO->setGoodsName('面包');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.16');
$detailVO->setGoodsTaxRate('0.16');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1070508030000000000');
$detailVO->setGoodsName('米、面制半成品');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.17');
$detailVO->setGoodsTaxRate('0.17');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1030208010000000000');
$detailVO->setGoodsName('婴幼儿用均化食品');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.17');
$detailVO->setGoodsTaxRate('0.17');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1030212010000000000');
$detailVO->setGoodsName('食品用原料粉');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.17');
$detailVO->setGoodsTaxRate('0.17');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$detailVO = new InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
$detailVO->setGoodsLineNo($goodsLineNo++);
$detailVO->setGoodsLineNature('0');
$detailVO->setGoodsCode('1030212990000000000');
$detailVO->setGoodsName('其他食品用类似原料');
$detailVO->setGoodsTotalPrice('1');
$detailVO->setGoodsTotalTax('0.17');
$detailVO->setGoodsTaxRate('0.17');
$detailVO->setPriceTaxMark('0');
$detailVO->setPreferentialMark('0');
$detailList[] = $detailVO;

$vo->setInvoiceDetailsList($detailList);
//$data = $vo->getData();
//$err = $vo->getError();
//var_export(['data' => $data, 'err' => $err]);exit;
//调用服务方法，获取资源
$resp = $invoiceservice->openInvoice($vo);

var_export($resp);