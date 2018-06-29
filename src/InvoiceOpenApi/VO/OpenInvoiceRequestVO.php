<?php

namespace InvoiceOpenApi\VO;

class OpenInvoiceRequestVO extends BaseVO
{
    protected $deviceType;//设备类型 0税控服务器，1税控盘
    protected $serialNo;//开票流水号，唯一标志开票请求。支持数字字母下划线组合
    protected $organizationCode;//组织机构代码，不为空表示所开票归属于当前机构
    protected $invoiceTypeCode;//发票种类编码，004:增值税专用发票，007:增值税普通发票，026：增值税电子发票，025：增值税卷式发票
    protected $sellerTaxNo;//销方单位税号
    protected $invoiceTerminalCode;//开票点编码
    protected $invoiceSpecialMark;//特殊票种标记，00：普通发票 02：农业发票 默认：00
    protected $buyerTaxNo;//购方单位税号
    protected $buyerName;//购方单位名称
    protected $buyerAddressPhone;//购方地址及电话，专票必填
    protected $buyerBankAccount;//购方开户行及账号，专票必填
    protected $drawer;//开票人,电子发票8个字符；专普票16个字符
    protected $checker;//复核人，电子发票8个字符；专普票16个字符
    protected $payee;//收款人，电子发票8个字符；专普票16个字符
    protected $invoiceType;//开票类型0:正数发票（蓝票） 1：负数发票（红票）
    protected $invoiceListMark = '0';//“清单标志： 0：无清单 1：带清单 （发票明细大于等于8行必须带清单） PS 电子发票只能设置为0
    protected $redInfoNo;//红字信息表编号
    protected $originalInvoiceCode;//原发票代码(开红票时传入)
    protected $originalInvoiceNo;//原发票号码(开红票时传入)
    protected $taxationMode;//征税方式 0：普通征税，2：差额征税
    protected $deductibleAmount;//扣除额，当征税方式为差额征税时必填。数值必须小于价税合计。注：税控服务器差额征税开负票时，扣除额必须为空。
    protected $invoiceTotalPrice = 0.00;//合计金额，保留两位小数
    protected $invoiceTotalTax = 0.00;//合计税额，保留两位小数
    protected $invoiceTotalPriceTax = 0.00;//价税合计，保留两位小数
    protected $signatureParameter;//签名值参数; 默认为：0000004282000000
    protected $taxDiskNo;//税控盘编号，设备类型为1时必填
    protected $taxDiskKey;//税控盘口令，设备类型为1时必填
    protected $taxDiskPassword;//税务数字证书密码，设备类型为1时必填
    protected $goodsCodeVersion;//商品编码版本号
    protected $consolidatedTaxRate;//综合税率
    protected $notificationNo;//通知单编号
    protected $remarks;//备注
    protected $invoiceDetailsList = [];//清单

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
     * @return OpenInvoiceRequestVO
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;

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
     * @return OpenInvoiceRequestVO
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganizationCode()
    {
        return $this->organizationCode;
    }

    /**
     * @param mixed $organizationCode
     *
     * @return OpenInvoiceRequestVO
     */
    public function setOrganizationCode($organizationCode)
    {
        $this->organizationCode = $organizationCode;

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
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceTypeCode($invoiceTypeCode)
    {
        $this->invoiceTypeCode = $invoiceTypeCode;

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
     * @return OpenInvoiceRequestVO
     */
    public function setSellerTaxNo($sellerTaxNo)
    {
        $this->sellerTaxNo = $sellerTaxNo;

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
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceTerminalCode($invoiceTerminalCode)
    {
        $this->invoiceTerminalCode = $invoiceTerminalCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceSpecialMark()
    {
        return $this->invoiceSpecialMark;
    }

    /**
     * @param mixed $invoiceSpecialMark
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceSpecialMark($invoiceSpecialMark)
    {
        $this->invoiceSpecialMark = $invoiceSpecialMark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerTaxNo()
    {
        return $this->buyerTaxNo;
    }

    /**
     * @param mixed $buyerTaxNo
     *
     * @return OpenInvoiceRequestVO
     */
    public function setBuyerTaxNo($buyerTaxNo)
    {
        $this->buyerTaxNo = $buyerTaxNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerName()
    {
        return $this->buyerName;
    }

    /**
     * @param mixed $buyerName
     *
     * @return OpenInvoiceRequestVO
     */
    public function setBuyerName($buyerName)
    {
        $this->buyerName = $buyerName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerAddressPhone()
    {
        return $this->buyerAddressPhone;
    }

    /**
     * @param mixed $buyerAddressPhone
     *
     * @return OpenInvoiceRequestVO
     */
    public function setBuyerAddressPhone($buyerAddressPhone)
    {
        $this->buyerAddressPhone = $buyerAddressPhone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerBankAccount()
    {
        return $this->buyerBankAccount;
    }

    /**
     * @param mixed $buyerBankAccount
     *
     * @return OpenInvoiceRequestVO
     */
    public function setBuyerBankAccount($buyerBankAccount)
    {
        $this->buyerBankAccount = $buyerBankAccount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDrawer()
    {
        return $this->drawer;
    }

    /**
     * @param mixed $drawer
     *
     * @return OpenInvoiceRequestVO
     */
    public function setDrawer($drawer)
    {
        $this->drawer = $drawer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChecker()
    {
        return $this->checker;
    }

    /**
     * @param mixed $checker
     *
     * @return OpenInvoiceRequestVO
     */
    public function setChecker($checker)
    {
        $this->checker = $checker;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayee()
    {
        return $this->payee;
    }

    /**
     * @param mixed $payee
     *
     * @return OpenInvoiceRequestVO
     */
    public function setPayee($payee)
    {
        $this->payee = $payee;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceType()
    {
        return $this->invoiceType;
    }

    /**
     * @param mixed $invoiceType
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceType($invoiceType)
    {
        $this->invoiceType = $invoiceType;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceListMark()
    {
        return $this->invoiceListMark;
    }

    /**
     * @param string $invoiceListMark
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceListMark($invoiceListMark)
    {
        $this->invoiceListMark = $invoiceListMark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedInfoNo()
    {
        return $this->redInfoNo;
    }

    /**
     * @param mixed $redInfoNo
     *
     * @return OpenInvoiceRequestVO
     */
    public function setRedInfoNo($redInfoNo)
    {
        $this->redInfoNo = $redInfoNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalInvoiceCode()
    {
        return $this->originalInvoiceCode;
    }

    /**
     * @param mixed $originalInvoiceCode
     *
     * @return OpenInvoiceRequestVO
     */
    public function setOriginalInvoiceCode($originalInvoiceCode)
    {
        $this->originalInvoiceCode = $originalInvoiceCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalInvoiceNo()
    {
        return $this->originalInvoiceNo;
    }

    /**
     * @param mixed $originalInvoiceNo
     *
     * @return OpenInvoiceRequestVO
     */
    public function setOriginalInvoiceNo($originalInvoiceNo)
    {
        $this->originalInvoiceNo = $originalInvoiceNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxationMode()
    {
        return $this->taxationMode;
    }

    /**
     * @param mixed $taxationMode
     *
     * @return OpenInvoiceRequestVO
     */
    public function setTaxationMode($taxationMode)
    {
        $this->taxationMode = $taxationMode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeductibleAmount()
    {
        return $this->deductibleAmount;
    }

    /**
     * @param mixed $deductibleAmount
     *
     * @return OpenInvoiceRequestVO
     */
    public function setDeductibleAmount($deductibleAmount)
    {
        $this->deductibleAmount = $deductibleAmount;

        return $this;
    }

    /**
     * @return float
     */
    public function getInvoiceTotalPrice()
    {
        return $this->invoiceTotalPrice;
    }

    /**
     * @param float $invoiceTotalPrice
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceTotalPrice($invoiceTotalPrice)
    {
        $this->invoiceTotalPrice = $invoiceTotalPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getInvoiceTotalTax()
    {
        return $this->invoiceTotalTax;
    }

    /**
     * @param float $invoiceTotalTax
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceTotalTax($invoiceTotalTax)
    {
        $this->invoiceTotalTax = $invoiceTotalTax;

        return $this;
    }

    /**
     * @return float
     */
    public function getInvoiceTotalPriceTax()
    {
        return $this->invoiceTotalPriceTax;
    }

    /**
     * @param float $invoiceTotalPriceTax
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceTotalPriceTax($invoiceTotalPriceTax)
    {
        $this->invoiceTotalPriceTax = $invoiceTotalPriceTax;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignatureParameter()
    {
        return $this->signatureParameter;
    }

    /**
     * @param mixed $signatureParameter
     *
     * @return OpenInvoiceRequestVO
     */
    public function setSignatureParameter($signatureParameter)
    {
        $this->signatureParameter = $signatureParameter;

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
     * @return OpenInvoiceRequestVO
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
     * @return OpenInvoiceRequestVO
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
     * @return OpenInvoiceRequestVO
     */
    public function setTaxDiskPassword($taxDiskPassword)
    {
        $this->taxDiskPassword = $taxDiskPassword;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsCodeVersion()
    {
        return $this->goodsCodeVersion;
    }

    /**
     * @param mixed $goodsCodeVersion
     *
     * @return OpenInvoiceRequestVO
     */
    public function setGoodsCodeVersion($goodsCodeVersion)
    {
        $this->goodsCodeVersion = $goodsCodeVersion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConsolidatedTaxRate()
    {
        return $this->consolidatedTaxRate;
    }

    /**
     * @param mixed $consolidatedTaxRate
     *
     * @return OpenInvoiceRequestVO
     */
    public function setConsolidatedTaxRate($consolidatedTaxRate)
    {
        $this->consolidatedTaxRate = $consolidatedTaxRate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotificationNo()
    {
        return $this->notificationNo;
    }

    /**
     * @param mixed $notificationNo
     *
     * @return OpenInvoiceRequestVO
     */
    public function setNotificationNo($notificationNo)
    {
        $this->notificationNo = $notificationNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     *
     * @return OpenInvoiceRequestVO
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * @return array
     */
    public function getInvoiceDetailsList()
    {
        return $this->invoiceDetailsList;
    }

    /**
     * @param array $invoiceDetailsList
     *
     * @return OpenInvoiceRequestVO
     */
    public function setInvoiceDetailsList($invoiceDetailsList)
    {
        $this->invoiceDetailsList = $invoiceDetailsList;

        return $this;
    }

}