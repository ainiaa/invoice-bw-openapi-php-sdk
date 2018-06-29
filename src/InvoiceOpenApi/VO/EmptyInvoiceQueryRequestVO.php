<?php

namespace InvoiceOpenApi\VO;

class EmptyInvoiceQueryRequestVO extends BaseVO
{
    protected $deviceType;//设备类型0税控服务器，1税控盘
    protected $sellerTaxNo;//销方税号，查询条件
    protected $invoiceTypeCode;//发票种类编码: 004:增值税专用发票，007:增值税普通发票，026：增值税电子发票，025：增值税卷式发票
    protected $invoiceTerminalCode;//开票点编码
    protected $taxDiskNo;//税控盘编号，设备类型为1时必填
    protected $taxDiskKey;//税控盘口令，设备类型为1时必填
    protected $taxDiskPassword;//税务数字证书密码，设备类型为1时必填

    /**
     * @return mixed
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * @param mixed $deviceType
     *
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;

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
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setSellerTaxNo($sellerTaxNo)
    {
        $this->sellerTaxNo = $sellerTaxNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceTypeCode()
    {
        return $this->invoiceTypeCode;
    }

    /**
     * @param mixed $invoiceTypeCode
     *
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setInvoiceTypeCode($invoiceTypeCode)
    {
        $this->invoiceTypeCode = $invoiceTypeCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceTerminalCode()
    {
        return $this->invoiceTerminalCode;
    }

    /**
     * @param mixed $invoiceTerminalCode
     *
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setInvoiceTerminalCode($invoiceTerminalCode)
    {
        $this->invoiceTerminalCode = $invoiceTerminalCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxDiskNo()
    {
        return $this->taxDiskNo;
    }

    /**
     * @param mixed $taxDiskNo
     *
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setTaxDiskNo($taxDiskNo)
    {
        $this->taxDiskNo = $taxDiskNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxDiskKey()
    {
        return $this->taxDiskKey;
    }

    /**
     * @param mixed $taxDiskKey
     *
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setTaxDiskKey($taxDiskKey)
    {
        $this->taxDiskKey = $taxDiskKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxDiskPassword()
    {
        return $this->taxDiskPassword;
    }

    /**
     * @param mixed $taxDiskPassword
     *
     * @return EmptyInvoiceQueryRequestVO
     */
    public function setTaxDiskPassword($taxDiskPassword)
    {
        $this->taxDiskPassword = $taxDiskPassword;

        return $this;
    }

}