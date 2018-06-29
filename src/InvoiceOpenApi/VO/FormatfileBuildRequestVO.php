<?php

namespace InvoiceOpenApi\VO;

class FormatfileBuildRequestVO extends BaseVO
{
    protected $sellerTaxNo;//纳税人识别号
    protected $serialNo;//开票流水号
    protected $invoiceCode;//发票代码
    protected $invoiceNo;//发票号码
    protected $pushType;//推送标志 0：不推送 1：推送（邮箱电话必填一个）
    protected $buyerEmail;//购方客户email
    protected $buyerPhone;//购方客户手机号

    /**
     * @return mixed
     */
    public function getSellerTaxNo()
    {
        return $this->sellerTaxNo;
    }

    /**
     * @param mixed $sellerTaxNo
     */
    public function setSellerTaxNo($sellerTaxNo)
    {
        $this->sellerTaxNo = $sellerTaxNo;
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
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;
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
     */
    public function setInvoiceCode($invoiceCode)
    {
        $this->invoiceCode = $invoiceCode;
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
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;
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
     */
    public function setPushType($pushType)
    {
        $this->pushType = $pushType;
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
     */
    public function setBuyerEmail($buyerEmail)
    {
        $this->buyerEmail = $buyerEmail;
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
     */
    public function setBuyerPhone($buyerPhone)
    {
        $this->buyerPhone = $buyerPhone;
    }//购方客户手机号
}