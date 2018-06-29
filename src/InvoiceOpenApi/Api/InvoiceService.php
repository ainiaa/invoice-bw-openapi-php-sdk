<?php

namespace InvoiceOpenApi\Api;

use CoreOpenApi\Api\RequestService;
use InvoiceOpenApi\VO\FormatfileBuildRequestVO;

class InvoiceService extends RequestService
{
    /**
     * 开票
     */
    public function openInvoice($params)
    {
        $method = $this->getMethodByAlias('OPEN_INVOICE');

        return $this->call($method, $params);
    }

    /**
     * 生成版式文件
     *
     * @param $params
     *
     * @return \stdClass
     */
    public function formatFileBuild(FormatfileBuildRequestVO $vo)
    {
        $method = $this->getMethodByAlias('FORMATFILE_BUILD');
        $params = $vo->toArray();
        foreach ($params as $index => $param)
        {
            if (is_null($param)) {
                $params[$index] = '';
            }
        }
//        var_export($params);exit;

        return $this->call($method, $params);
    }

    /**
     * 空白发票查询
     */
    public function emptyInvoceQuery($params)
    {
        $method = $this->getMethodByAlias('EMPTY_INVOICE_QUERY');

        return $this->call($method, $params);
    }

    /**
     * 版式文件查询
     *
     * @param $params
     *
     * @return \stdClass
     */
    public function formatFileQuery($params)
    {
        $method = $this->getMethodByAlias('FORMATFILE_QUERY');

        return $this->call($method, $params);
    }
}