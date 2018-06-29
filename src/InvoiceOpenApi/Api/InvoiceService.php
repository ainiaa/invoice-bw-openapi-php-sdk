<?php

namespace InvoiceOpenApi\Api;

use CoreOpenApi\Api\RequestService;
use InvoiceOpenApi\VO\FormatfileBuildRequestVO;
use InvoiceOpenApi\VO\FormatfileQueryRequestVO;
use InvoiceOpenApi\VO\CompanySearchRequestVO;
use InvoiceOpenApi\VO\EmptyInvoiceQueryRequestVO;
use InvoiceOpenApi\VO\InvalidInvoiceRequestVO;

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

        return $this->call($method, $params);
    }

    /**
     * 空白发票查询
     */
    public function emptyInvoceQuery(EmptyInvoiceQueryRequestVO $vo)
    {
        $method = $this->getMethodByAlias('EMPTY_INVOICE_QUERY');
        $params = $vo->toArray();

        return $this->call($method, $params);
    }

    /**
     * 版式文件查询
     *
     * @param FormatfileQueryRequestVO $vo
     *
     * @return \stdClass
     * @internal param $params
     *
     */
    public function formatFileQuery(FormatfileQueryRequestVO $vo)
    {
        $method = $this->getMethodByAlias('FORMATFILE_QUERY');
        $params = $vo->toArray();

        return $this->call($method, $params);
    }

    /**
     * 云抬头获取
     *
     * @param CompanySearchRequestVO $vo
     *
     * @return mixed
     */
    public function companySearch(CompanySearchRequestVO $vo)
    {
        $method = $this->getMethodByAlias('COMPANY_SEARCH');
        $params = $vo->toArray();

        return $this->call($method, $params);
    }

    /**
     * 作废发票
     *
     * @param InvalidInvoiceRequestVO $vo
     *
     * @return mixed
     */
    public function invalidInvoice(InvalidInvoiceRequestVO $vo)
    {
        $method = $this->getMethodByAlias('INVALID_INVOICE');
        $params = $vo->toArray();

        return $this->call($method, $params);
    }
}