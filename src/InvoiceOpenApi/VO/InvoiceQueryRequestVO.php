<?php

namespace InvoiceOpenApi\VO;

class InvoiceQueryRequestVO extends InvoiceBaseVO
{
    protected $sellerTaxNo;//销方税号，查询
    protected $invoiceQueryType;//查询类型 1发票流水号查询  2发票号码和发票代码查询 3纳税人识别号【销方】  4开票终端标识 5开票日期起止  6.购方信息
    protected $serialNo;//开票流水号
    protected $invoiceCode;//发票代码
    protected $invoiceNo;//发票号码
    protected $invoiceTerminalCode;//开票点编码
    protected $invoiceStartDate;//开票日期起，格式：yyyyMMddHHmmss
    protected $invoiceEndDate;//开票日期止，格式：yyyyMMddHHmmss
    protected $buyerTaxNo;//购方单位
    protected $buyerName;//购方单位名称
    protected $rule = [
        ['invoiceQueryType', 'require|length:1', 'invoiceQueryType required|invoiceQueryType 长度为：1'],
        ['sellerTaxNo', 'require|max:20', 'sellerTaxNo required|sellerTaxNo 最大长度为：20'],
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
     * @return InvoiceQueryRequestVO
     */
    public function setSellerTaxNo($sellerTaxNo)
    {
        $this->sellerTaxNo = $sellerTaxNo;

        return $this;
    }

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
     * @return InvoiceQueryRequestVO
     */
    public function setInvoiceQueryType($invoiceQueryType)
    {
        $this->invoiceQueryType = $invoiceQueryType;

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
     * @return InvoiceQueryRequestVO
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
     * @return InvoiceQueryRequestVO
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
     * @return InvoiceQueryRequestVO
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

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
     * @return InvoiceQueryRequestVO
     */
    public function setInvoiceTerminalCode($invoiceTerminalCode)
    {
        $this->invoiceTerminalCode = $invoiceTerminalCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceStartDate()
    {
        return $this->invoiceStartDate;
    }

    /**
     * @param mixed $invoiceStartDate
     *
     * @return InvoiceQueryRequestVO
     */
    public function setInvoiceStartDate($invoiceStartDate)
    {
        $this->invoiceStartDate = $invoiceStartDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceEndDate()
    {
        return $this->invoiceEndDate;
    }

    /**
     * @param mixed $invoiceEndDate
     *
     * @return InvoiceQueryRequestVO
     */
    public function setInvoiceEndDate($invoiceEndDate)
    {
        $this->invoiceEndDate = $invoiceEndDate;

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
     * @return InvoiceQueryRequestVO
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
     * @return InvoiceQueryRequestVO
     */
    public function setBuyerName($buyerName)
    {
        $this->buyerName = $buyerName;

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
     * @return InvoiceQueryRequestVO
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }
}