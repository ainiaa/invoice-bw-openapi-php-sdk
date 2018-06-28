<?php

namespace InvoiceOpenApi\Api;

use CoreOpenApi\Api\RequestService;


class InvoiceService extends RequestService
{
    const MAPPING = [
            'OPEN_INVOICE'        => 'baiwang.invoice.open', //开票
            'FORMATFILE_BUILD'    => 'baiwang.formatfile.bulid',//生成版式文件
            'FORMATFILE_QUERY'    => 'baiwang.formatfile.query',//查询版式文件
            'EMPTY_INVOICE_QUERY' => 'baiwang.invoice.empty.query',//空白发票查询
    ];

    /**
     * 开票
     */
    public function openInvoice($params)
    {
        $method = self::MAPPING['OPEN_INVOICE'];

        return $this->call($method, $params);
    }

    /**
     * @param $params
     *
     * @return \stdClass
     */
    public function formatFileBuild($params)
    {
        $method = self::MAPPING['FORMATFILE_BUILD'];

        return $this->call($method, $params);
    }

    /**
     * 空白发票查询
     */
    public function emptyInvoceQuery($params)
    {
        $method = self::MAPPING['EMPTY_INVOICE_QUERY'];

        return $this->call($method, $params);
    }

    /**
     * @param $params
     *
     * @return \stdClass
     */
    public function formatFileQuery($params)
    {
        $method = self::MAPPING['FORMATFILE_QUERY'];

        return $this->call($method, $params);
    }

    public function getToken()
    {
        return $this->client->getToken();
    }
}