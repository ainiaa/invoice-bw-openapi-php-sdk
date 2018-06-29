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

$vo     = new \InvoiceOpenApi\VO\CompanySearchRequestVO();
$vo->setAccuracy("true");//是否精准查询
$vo->setCompanyName("杭州威达计算机网络工程有限公司")->setTaxId("913301107272174037");//公司名和税号
//$vo->setSellerTaxNo('91500000747150426A')->setSerialNo('cd200000004')->setInvoiceNo('82537206')->setPushType('0')->setInvoiceCode('150003521055');
$resp = $invoiceservice->companySearch($vo);

var_export($resp);