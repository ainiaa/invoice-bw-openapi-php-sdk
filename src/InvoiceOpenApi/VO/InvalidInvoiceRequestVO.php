<?php

namespace InvoiceOpenApi\VO;

use CoreOpenApi\VO\BaseVO;

class InvalidInvoiceRequestVO extends BaseVO
{
    protected $deviceType;//设备类型 0税控服务器，1税控盘
    protected $invoiceInvalidType = 1;//作废类型 0：空白票作废 1：已开票作废
    protected $sellerTaxNo;//纳税人识别号
    protected $invoiceTypeCode;//发票种类编码:004:增值税专用发票，007:增值税普通发票，026：增值税电子发票，025：增值税卷式发票
    protected $invoiceTerminalCode;//开票点编码
    protected $invoiceCode;//发票代码
    protected $invoiceNo;//发票号码
    protected $taxDiskNo;// 税控盘编号，设备类型为1时必填
    protected $taxDiskKey;//税控盘口令，设备类型为1时必填
    protected $taxDiskPassword;//税务数字证书密码，设备类型为1时必填
    protected $invoiceInvalidOperator;//作废人
    protected $rule = [
        ['deviceType', 'require|length:1', 'deviceType required|deviceType长度为：1'],
        ['serialNo', 'require', 'serialNo required'],
        ['sellerTaxNo', 'require|max:20', 'sellerTaxNo required|sellerTaxNo最大长度为：20'],
        ['invoiceTypeCode', 'require|length:3', 'sellerTaxNo required|invoiceTypeCode长度为：3'],
        ['invoiceTerminalCode', 'require|max:30', 'sellerTaxNo required|invoiceTerminalCode最大长度为：30'],
        ['invoiceCode', 'require|max:12', 'invoiceCode required|invoiceCode最大长度为：12'],
        ['invoiceNo', 'require|max:8', 'invoiceNo required|invoiceCode最大长度为：8'],
        [
            'invoiceInvalidOperator',
            'invoiceInvalidOperator|max:32',
            'invoiceInvalidOperator required|invoiceInvalidOperator最大长度为：32',
        ],
    ];

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
     * @return InvalidInvoiceRequestVO
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return int
     */
    public function getInvoiceInvalidType()
    {
        return $this->invoiceInvalidType;
    }

    /**
     * @param int $invoiceInvalidType
     *
     * @return InvalidInvoiceRequestVO
     */
    public function setInvoiceInvalidType($invoiceInvalidType)
    {
        $this->invoiceInvalidType = $invoiceInvalidType;

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
     * @return InvalidInvoiceRequestVO
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
     * @return InvalidInvoiceRequestVO
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
     * @return InvalidInvoiceRequestVO
     */
    public function setInvoiceTerminalCode($invoiceTerminalCode)
    {
        $this->invoiceTerminalCode = $invoiceTerminalCode;

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
     * @return InvalidInvoiceRequestVO
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
     * @return InvalidInvoiceRequestVO
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

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
     * @return InvalidInvoiceRequestVO
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
     * @return InvalidInvoiceRequestVO
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
     * @return InvalidInvoiceRequestVO
     */
    public function setTaxDiskPassword($taxDiskPassword)
    {
        $this->taxDiskPassword = $taxDiskPassword;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceInvalidOperator()
    {
        return $this->invoiceInvalidOperator;
    }

    /**
     * @param mixed $invoiceInvalidOperator
     *
     * @return InvalidInvoiceRequestVO
     */
    public function setInvoiceInvalidOperator($invoiceInvalidOperator)
    {
        $this->invoiceInvalidOperator = $invoiceInvalidOperator;

        return $this;
    }
}