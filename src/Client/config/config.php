<?php
return [
    'redis'   => [
        'host'    => '127.0.0.1',
        'port'    => 6379,
        'timeout' => 5,
    ],

    //开票
    'invoice' => [
        'appKey'     => '10000005',
        'appSecret'  => 'b65025d0-19d2-4841-88f4-ff4439b8da58',
        'methodList' => [
            'OPEN_INVOICE'        => 'baiwang.invoice.open', //开票
            'FORMATFILE_BUILD'    => 'baiwang.formatfile.bulid',//生成版式文件
            'FORMATFILE_QUERY'    => 'baiwang.formatfile.query',//查询版式文件
            'EMPTY_INVOICE_QUERY' => 'baiwang.invoice.empty.query',//空白发票查询
            'COMPANY_SEARCH'      => 'baiwang.bizinfo.companySearch', //云抬头获取（根据公司名和/或税号查询，）
            'INVALID_INVOICE'     => 'baiwang.invoice.invalid',//发票作废
            'PURCHASE_QUERY'      => 'baiwang.invoice.purchase.query',//剩余发票数量
        ],
        'extParams'  => [
            'requestUrl'          => 'http://60.205.83.27/router/rest',
            'username'            => 'admin_1800000021168',
            'password'            => 'a123456',
            'salt'                => '94db610c5c3049df8da3e9ac91390015',
            'version'             => '2.1',
            'sellerTaxNo'         => '91500000747150426A', //公司税号
            'payee'               => '收款人',//收款人
            'checker'             => '复核人',//复核人
            'drawer'              => '开票人',//开票人
            'invoiceTerminalCode' => 'kpyuan002',//开票点编码
            'invoiceTypeCode'     => '026',//发票种类编码
            'machineNo'           => '499111006380',//盘号
            'goodsUnit'           => '份', //商品单位
            'taxationMode'        => '0',//征税方式 0：普通征税，2：差额征税
            'taxDiskKey'          => '',
            'taxDiskNo'           => '',
            'taxDiskPassword'     => '',
            'deviceType'          => '0',//设备类型 0:税控服务器，1:税控盘
            'curlOption'          => [
                'default' => [
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                ],
            ],
        ],
    ],
    //开票结束
];