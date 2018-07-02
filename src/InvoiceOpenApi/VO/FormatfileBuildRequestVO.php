<?php

namespace InvoiceOpenApi\VO;

use CoreOpenApi\VO\BaseVO;

class FormatfileBuildRequestVO extends BaseVO
{
    protected $sellerTaxNo;//纳税人识别号
    protected $serialNo;//开票流水号
    protected $invoiceCode;//发票代码
    protected $invoiceNo;//发票号码
    protected $pushType;//推送标志 0：不推送 1：推送（邮箱电话必填一个）
    protected $buyerEmail;//购方客户email
    protected $buyerPhone;
    protected $rule = [
        ['sellerTaxNo', 'require|max:20', 'sellerTaxNo required|sellerTaxNo最大长度为：20'],
        ['serialNo', 'max:50', 'serialNo最大长度为：50'],
        ['pushType', 'require|length:1', 'pushType required|pushType长度为：1'],
    ];

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
     * @return FormatfileBuildRequestVO
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
     * @return FormatfileBuildRequestVO
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
     * @return FormatfileBuildRequestVO
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
     * @return FormatfileBuildRequestVO
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPushType()
    {
        return $this->pushType;
    }

    /**
     * @param mixed $pushType
     *
     * @return FormatfileBuildRequestVO
     */
    public function setPushType($pushType)
    {
        $this->pushType = $pushType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerEmail()
    {
        return $this->buyerEmail;
    }

    /**
     * @param mixed $buyerEmail
     *
     * @return FormatfileBuildRequestVO
     */
    public function setBuyerEmail($buyerEmail)
    {
        $this->buyerEmail = $buyerEmail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerPhone()
    {
        return $this->buyerPhone;
    }

    /**
     * @param mixed $buyerPhone
     *
     * @return FormatfileBuildRequestVO
     */
    public function setBuyerPhone($buyerPhone)
    {
        $this->buyerPhone = $buyerPhone;

        return $this;
    }//购方客户手机号

}