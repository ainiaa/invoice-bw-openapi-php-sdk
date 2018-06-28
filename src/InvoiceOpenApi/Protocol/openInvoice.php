<?php

class BaiWangInvoiceWrapper
{

    private $clientId = '10000005';
    private $clientSecret = 'b65025d0-19d2-4841-88f4-ff4439b8da58';
    private $username = 'admin_1800000021168';
    private $password = 'a12345694';
    private $salt = 'db610c5c3049df8da3e9ac91390015';

    /**
     * http post 封装
     *
     * @param $url
     * @param $data
     *
     * @return mixed
     */
    public function httpPost($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
		
        curl_close($ch);

        error_log($url . ':' . $data . PHP_EOL, 3, '/wwwroot/log.log');
        return $res;
    }

    /**
     * 发送请求 (token)
     *
     * @param $url
     * @param $data
     *
     * @return mixed
     */
    public function httpPostToken($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
		
        curl_close($ch);
        return $res;
    }

    public function getPassword()
    {
        return sha1(md5($this->password . $this->salt));
    }


    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        $method        = 'baiwang.oauth.token';
        $client_id     = $this->clientId;
        $client_secret = $this->clientSecret;
        $username      = $this->username;
        $password      = $this->getPassword();
        $version       = '3.0';
        $timestamp     = time() * 1000;
        $url           = "http://60.205.83.27/router/rest";
        $data          = "timestamp={$timestamp}&password={$password}&method=baiwang.oauth.token&grant_type=password&client_secret={$client_secret}&version=1.0&client_id={$client_id}&username={$username}";
        $res           = $this->httpPostToken($url, $data);
        $res           = json_decode($res, true);
        $token         = $res["response"]["access_token"];
        return $token;
    }

    /**
     * 拼接公共参数
     *
     * @param $params
     *
     * @return string
     */

    public function getParamStrFromMap($params)
    {
        ksort($params);
        $stringToBeSigned = "";
        foreach ($params as $k => $v) {
            if (strcmp("sign", $k) != 0) {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        return $stringToBeSigned;
    }

    /**
     * 返回签名
     *
     * @param array  $params 公共参数
     * @param string $body   业务参数
     * @param        $secret
     *
     * @return string
     */
    public function sign($params, $body, $secret)
    {
        ksort($params);

        $stringToBeSigned = $secret;
        $stringToBeSigned .= $this->getParamStrFromMap($params);
        if ($body) {
            $stringToBeSigned .= $body;
        }
        $stringToBeSigned .= $secret;
        return strtoupper(md5($stringToBeSigned));
    }

    /**
     * 获取返回值
     * @return mixed
     */
    public function openInvoice()
    {
        $method    = 'baiwang.invoice.open';
        $appKey    = $this->clientId;
        $token     = $this->getToken();
        $timestamp = time();
        $version   = '3.0';
        $secret    = $this->clientSecret;
        $type      = 'sync';
        $format    = 'json';
        $params    = array(
                'method'    => $method,
                'appKey'    => $appKey,
                'token'     => $token,
                'timestamp' => $timestamp,
                'version'   => $version,
                'format'    => $format,
                'type'      => $type,
        );
        $body      = array(
                'deviceType'           => '0',
                'organizationCode'     => '',
                'serialNo'             => 'cd200000003',
                'invoiceTypeCode'      => '026',
                'sellerTaxNo'          => '91500000747150426A',
                'invoiceTerminalCode'  => 'kpyuan002',
                'invoiceSpecialMark'   => '00',
                'buyerTaxNo'           => '',
                'buyerName'            => '购方名称',
                'buyerAddressPhone'    => '',
                'buyerBankAccount'     => '',
                'drawer'               => '黄惠',
                'checker'              => '邱亚琪',
                'payee'                => '邱亚琪',
                'invoiceType'          => '0',
                'invoiceListMark'      => '0',//电子发票， 该选项只能设置为0
                'redInfoNo'            => '',
                'originalInvoiceCode'  => '',
                'originalInvoiceNo'    => '',
                'taxationMode'         => '0',
                'deductibleAmount'     => '',
                'invoiceTotalPrice'    => '10',
                'invoiceTotalPriceTax' => '11.44',
                'invoiceTotalTax'      => '1.44',
                'signatureParameter'   => '',
                'taxDiskNo'            => '',
                'taxDiskKey'           => '',
                'taxDiskPassword'      => '',
                'goodsCodeVersion'     => '',
                'consolidatedTaxRate'  => '',
                'notificationNo'       => '',
                'remarks'              => '注释内容',
                'invoiceDetailsList'   => array(
                        0 => array(
                                'goodsLineNo'          => '1',
                                'goodsLineNature'      => '0',
                                'goodsCode'            => '1070508030000000000',
                                'goodsExtendCode'      => '',
                                'goodsName'            => '葫芦娃',
                                'goodsTaxItem'         => '',
                                'goodsSpecification'   => '',
                                'goodsUnit'            => '',
                                'goodsQuantity'        => '',
                                'goodsPrice'           => '',
                                'goodsTotalPrice'      => '1',
                                'goodsTotalTax'        => '0.17',
                                'goodsTaxRate'         => '0.17',
                                'goodsDiscountLineNo'  => '',
                                'priceTaxMark'         => '0',
                                'vatSpecialManagement' => '',
                                'freeTaxMark'          => '',
                                'preferentialMark'     => '0',
                        ),
                    1 => array(
                            'goodsLineNo'          => '2',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1030201030000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '饼干',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.10',
                            'goodsTaxRate'         => '0.10',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    2 => array(
                            'goodsLineNo'          => '3',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1010502000000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '淡水虾',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.11',
                            'goodsTaxRate'         => '0.11',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    3 => array(
                            'goodsLineNo'          => '4',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1010503000000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '淡水蟹',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.11',
                            'goodsTaxRate'         => '0.11',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    4 => array(
                            'goodsLineNo'          => '5',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1010504000000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '淡水贝类',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.11',
                            'goodsTaxRate'         => '0.11',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    5 => array(
                            'goodsLineNo'          => '6',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1030201020000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '面包',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.16',
                            'goodsTaxRate'         => '0.16',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    6 => array(
                            'goodsLineNo'          => '7',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1070508030000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '米、面制半成品',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.17',
                            'goodsTaxRate'         => '0.17',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    7 => array(
                            'goodsLineNo'          => '8',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1030208010000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '婴幼儿用均化食品',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.17',
                            'goodsTaxRate'         => '0.17',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    8 => array(
                            'goodsLineNo'          => '9',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1030212010000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '食品用原料粉',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.17',
                            'goodsTaxRate'         => '0.17',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                    9 => array(
                            'goodsLineNo'          => '10',
                            'goodsLineNature'      => '0',
                            'goodsCode'            => '1030212990000000000',
                            'goodsExtendCode'      => '',
                            'goodsName'            => '其他食品用类似原料',
                            'goodsTaxItem'         => '',
                            'goodsSpecification'   => '',
                            'goodsUnit'            => '',
                            'goodsQuantity'        => '',
                            'goodsPrice'           => '',
                            'goodsTotalPrice'      => '1',
                            'goodsTotalTax'        => '0.17',
                            'goodsTaxRate'         => '0.17',
                            'goodsDiscountLineNo'  => '',
                            'priceTaxMark'         => '0',
                            'vatSpecialManagement' => '',
                            'freeTaxMark'          => '',
                            'preferentialMark'     => '0',
                    ),
                ),
        );
        //$body      = '{"requestId":"44c71436-7e6e-416d-9fea-1a2b06316d1e","sellerTaxNo":"91500000747150426A","businessId":"","deviceType":"0","organizationCode":"","serialNo":"cd10000020","invoiceSample":"","invoiceSpecialMark":"00","invoiceTypeCode":"026","invoiceTerminalCode":"kpyuan002","buyerTaxNo":"","buyerName":"购方名称","buyerAddressPhone":"","buyerBankAccount":"","drawer":"123","checker":"","payee":"","invoiceType":"0","invoiceListMark":"0","redInfoNo":"","originalInvoiceCode":"","originalInvoiceNo":"","taxationMode":"0","deductibleAmount":"","invoiceTotalPrice":"1","invoiceTotalTax":"0.17","invoiceTotalPriceTax":"1.17","signatureParameter":"","taxDiskNo":"","taxDiskKey":"","taxDiskPassword":"","goodsCodeVersion":"","consolidatedTaxRate":"","notificationNo":"","remarks":"","invoiceDetailsList":[{"goodsLineNo":"1","goodsLineNature":"0","goodsCode":"1070508030000000000","goodsExtendCode":"","goodsName":"葫芦娃","goodsTaxItem":"","goodsSpecification":"","goodsUnit":"","goodsQuantity":"","goodsPrice":"","goodsTotalPrice":"1","goodsTotalTax":"0.17","goodsTaxRate":"0.17","goodsDiscountLineNo":"","priceTaxMark":"0","vatSpecialManagement":"","freeTaxMark":"","preferentialMark":"0"}],"apiName":"baiwang.invoice.open","taxNo":"91500000747150426A","methodCode":"1000"}';
        $body = json_encode($body);
        $sign = $this->sign($params, $body, $secret);
        $res  = $this->httpPost(
                "http://60.205.83.27/router/rest?method={$method}&version={$version}&appKey={$appKey}&format={$format}&timestamp={$timestamp}&token={$token}&type={$type}&sign={$sign}",
                $body
        );
        return $res;
    }

    /**
     * 获得发票文件
     * @return mixed
     */
    public function formatfileBuild()
    {
        $method    = 'baiwang.formatfile.bulid';
        $appKey    = $this->clientId;
        $token     = $this->getToken();
        $timestamp = time();
        $version   = '3.0';
        $secret    = $this->clientSecret;
        $type      = 'sync';
        $format    = 'json';
        $params    = array(
                'method'    => $method,
                'appKey'    => $appKey,
                'token'     => $token,
                'timestamp' => $timestamp,
                'version'   => $version,
                'format'    => $format,
                'type'      => $type,
        );
        $body      = array(
                'sellerTaxNo' => '91500000747150426A',
                'serialNo'    => 'cd200000003',
                'invoiceCode' => '150003521055',
                'invoiceNo'   => '82537066',
                'pushType'    => '0',
                'buyerEmail'  => '',
                'buyerPhone'  => '',

        );
        $body      = json_encode($body);
        $sign      = $this->sign($params, $body, $secret);
        $res       = $this->httpPost(
                "http://60.205.83.27/router/rest?method={$method}&version={$version}&appKey={$appKey}&format={$format}&timestamp={$timestamp}&token={$token}&type={$type}&sign={$sign}",
                $body
        );
        return $res;
    }

    public function formatfileQuery()
    {
        $method    = 'baiwang.formatfile.query';
        $appKey    = $this->clientId;
        $token     = $this->getToken();
        $timestamp = time();
        $version   = '3.0';
        $secret    = $this->clientSecret;
        $type      = 'sync';
        $format    = 'json';
        $params    = array(
                'method'    => $method,
                'appKey'    => $appKey,
                'token'     => $token,
                'timestamp' => $timestamp,
                'version'   => $version,
                'format'    => $format,
                'type'      => $type,
        );
        $body      = array(
                'invoiceQueryType' => '0',
                'sellerTaxNo'      => '91500000747150426A',
                'serialNo'         => 'cd200000001',
                'invoiceCode'      => '150003521055',
                'invoiceNo'        => '82536982',
                'returnType'       => '2',
        );
        $body      = json_encode($body);
        $sign      = $this->sign($params, $body, $secret);
        $res       = $this->httpPost(
                "http://60.205.83.27/router/rest?method={$method}&version={$version}&appKey={$appKey}&format={$format}&timestamp={$timestamp}&token={$token}&type={$type}&sign={$sign}",
                $body
        );
        return $res;
    }

}

$baiWangInvoiceWrapper = new BaiWangInvoiceWrapper();

$r = $baiWangInvoiceWrapper->formatfileBuild();
echo $r;
//var_export($r);
