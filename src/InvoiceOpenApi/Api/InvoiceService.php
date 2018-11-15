<?php

namespace InvoiceOpenApi\Api;

use CoreOpenApi\Api\RequestService;
use InvoiceOpenApi\VO\FormatfileBuildRequestVO;
use InvoiceOpenApi\VO\FormatfileQueryRequestVO;
use InvoiceOpenApi\VO\CompanySearchRequestVO;
use InvoiceOpenApi\VO\EmptyInvoiceQueryRequestVO;
use InvoiceOpenApi\VO\InvalidInvoiceRequestVO;
use InvoiceOpenApi\VO\InvoiceQueryRequestVO;
use InvoiceOpenApi\VO\OpenInvoiceRequestVO;
use InvoiceOpenApi\VO\PurchaseQueryRequestVO;

class InvoiceService extends RequestService
{
    /**
     * 开票
     *
     * @param $params
     *
     * @return mixed
     */
    public function openInvoice(OpenInvoiceRequestVO $vo)
    {
        $method = $this->getMethodByAlias('OPEN_INVOICE');

        return $this->call($method, $vo);
    }

    /**
     * 生成版式文件
     *
     * @param FormatfileBuildRequestVO $vo
     *
     * @return mixed
     *
     */
    public function formatFileBuild(FormatfileBuildRequestVO $vo)
    {
        $method = $this->getMethodByAlias('FORMATFILE_BUILD');

        return $this->call($method, $vo);
    }

    /**
     * 空白发票查询
     *
     * @param EmptyInvoiceQueryRequestVO $vo
     *
     * @return mixed
     */
    public function emptyInvoceQuery(EmptyInvoiceQueryRequestVO $vo)
    {
        $method = $this->getMethodByAlias('EMPTY_INVOICE_QUERY');

        return $this->call($method, $vo);
    }

    /**
     * 版式文件查询
     *
     * @param FormatfileQueryRequestVO $vo
     *
     * @return mixed
     */
    public function formatFileQuery(FormatfileQueryRequestVO $vo)
    {
        $method = $this->getMethodByAlias('FORMATFILE_QUERY');

        return $this->call($method, $vo);
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

        return $this->call($method, $vo);
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

        return $this->call($method, $vo);
    }

    /**
     * 提供税控设备发票领购信息查询功能。
     */
    public function purchaseQuery(PurchaseQueryRequestVO $vo)
    {
        $method = $this->getMethodByAlias('PURCHASE_QUERY');

        return $this->call($method, $vo);
    }

    /**
     * 查询开票情况
     *
     * @param InvoiceQueryRequestVO $vo
     *
     * @return mixed
     */
    public function invoiceQuery(InvoiceQueryRequestVO $vo)
    {
        $method = $this->getMethodByAlias('INVOICE_QUERY');

        return $this->call($method, $vo);
    }
}