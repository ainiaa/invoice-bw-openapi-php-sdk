<?php

include './../../vendor/autoload.php';

use CoreOpenApi\Config\Config;
use InvoiceOpenApi\Api\InvoiceService;
use InvoiceOpenApi\Protocol\InvoiceClient;

//实例化一个配置类
$config    = include 'config.php';
$configObj = new Config($config);
$token     = 'df7667eb-35cf-4f2f-b8de-31f4b3ebcbc2';//'f0ba7209-ec18-4855-a661-3607f1fb3b81';//
$client    = new InvoiceClient($token, $configObj);
//使用config和token对象，实例化一个服务对象
$invoiceservice = new InvoiceService($client);


//token错误 array ( 'code' => 100007, 'message' => '错误的签名', 'subCode' => 500, 'subMessage' => '错误的签名', )
//token过期 array (    'code' => 100002,    'message' => 'token错误',    'subCode' => NULL,    'subMessage' => '',)
//$resp = $invoiceservice->getToken($config);
//var_export($resp);exit;

$vo     = new \InvoiceOpenApi\VO\FormatfileQueryRequestVO();
$vo->setInvoiceQueryType('0');
$vo->setSellerTaxNo('91500000747150426A');
$vo->setSerialNo('cd200000004');
//$vo->setInvoiceNo('82537206');
//$vo->setInvoiceCode('150003521055');
$vo->setReturnType('1');
//$vo->setSellerTaxNo('91500000747150426A')->setSerialNo('cd200000004')->setInvoiceNo('82537206')->setPushType('0')->setInvoiceCode('150003521055');
$resp = $invoiceservice->formatFileQuery($vo);

var_export($resp);