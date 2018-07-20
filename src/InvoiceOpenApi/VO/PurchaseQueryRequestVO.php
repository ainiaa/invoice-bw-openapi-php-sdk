<?php

namespace InvoiceOpenApi\VO;

class PurchaseQueryRequestVO extends InvoiceBaseVO
{
    protected $deviceType;//设备类型0税控服务器，1税控盘
    protected $sellerTaxNo;//纳税人识别号
    protected $invoiceTypeCode;//发票种类编码:004:增值税专用发票，007:增值税普通发票，026：增值税电子普通发票,025：增值税卷式发票
    protected $invoiceTerminalCode;//开票点编码
    protected $machineNo;// 机器编号，当设备类型为0时，必填

    protected $rule = [
        ['deviceType', 'require', 'deviceType required'],
        ['sellerTaxNo', 'require', 'sellerTaxNo required'],
        ['invoiceTypeCode', 'require', 'invoiceTypeCode required'],
        ['invoiceTerminalCode', 'require', 'invoiceTerminalCode required'],
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
     * @return PurchaseQueryRequestVO
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
     * @return PurchaseQueryRequestVO
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
     * @return PurchaseQueryRequestVO
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
     * @return PurchaseQueryRequestVO
     */
    public function setInvoiceTerminalCode($invoiceTerminalCode)
    {
        $this->invoiceTerminalCode = $invoiceTerminalCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMachineNo()
    {
        return $this->machineNo;
    }

    /**
     * @param mixed $machineNo
     *
     * @return PurchaseQueryRequestVO
     */
    public function setMachineNo($machineNo)
    {
        $this->machineNo = $machineNo;

        return $this;
    }

    /**
     * @return array
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param array $rule
     *
     * @return PurchaseQueryRequestVO
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }
}