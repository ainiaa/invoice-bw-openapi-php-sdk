<?php

namespace InvoiceOpenApi\VO;

use CoreOpenApi\VO\BaseVO;

class FormatfileQueryRequestVO extends BaseVO
{
    protected $invoiceQueryType;//查询类型 0：发票代码号码 1：发票流水号 2：保单号
    protected $sellerTaxNo;//纳税人识别号
    protected $serialNo;//开票流水号
    protected $invoiceCode;//发票代码
    protected $invoiceNo;//发票号码
    protected $returnType;//返回类型 1： URL 2：文件流 3： H5链接
    protected $rule = [
        ['invoiceQueryType', 'require|length:1', 'deviceType required|invoiceQueryType长度为：1'],
        ['sellerTaxNo', 'require|max:20', 'sellerTaxNo required|sellerTaxNo最大长度为：20'],
    ];

    /**
     * @return mixed
     */
    public function getInvoiceQueryType()
    {
        return $this->invoiceQueryType;
    }

    /**
     * @param mixed $invoiceQueryType
     *
     * @return FormatfileQueryRequestVO
     */
    public function setInvoiceQueryType($invoiceQueryType)
    {
        $this->invoiceQueryType = $invoiceQueryType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSellerTaxNo()
    {
        return $this->sellerTaxNo;
    }

    /**
     * @param mixed $sellerTaxNo
     *
     * @return FormatfileQueryRequestVO
     */
    public function setSellerTaxNo($sellerTaxNo)
    {
        $this->sellerTaxNo = $sellerTaxNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * @param mixed $serialNo
     *
     * @return FormatfileQueryRequestVO
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceCode()
    {
        return $this->invoiceCode;
    }

    /**
     * @param mixed $invoiceCode
     *
     * @return FormatfileQueryRequestVO
     */
    public function setInvoiceCode($invoiceCode)
    {
        $this->invoiceCode = $invoiceCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNo()
    {
        return $this->invoiceNo;
    }

    /**
     * @param mixed $invoiceNo
     *
     * @return FormatfileQueryRequestVO
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param mixed $returnType
     *
     * @return FormatfileQueryRequestVO
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;

        return $this;
    }

}