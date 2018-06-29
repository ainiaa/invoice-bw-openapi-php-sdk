<?php

namespace InvoiceOpenApi\VO;

/**
 * 开票详单信息
 * Class InvoiceDetailsRequestVO
 * @package InvoiceOpenApi\VO
 */
class InvoiceDetailsRequestVO extends BaseVO
{
    protected $goodsLineNo;//明细行号
    protected $goodsLineNature;//发票行性质，0：正常行 1：折扣行 2：被折扣行
    protected $goodsCode;//商品编码
    protected $goodsExtendCode;//自行编码
    protected $goodsName;//商品名称
    protected $goodsTaxItem;//商品税目
    protected $goodsSpecification;//规格型号
    protected $goodsUnit;//计量单位
    protected $goodsQuantity;//商品数量
    protected $goodsPrice = 0.00;//商品单价
    protected $goodsTotalPrice = 0.00;//金额
    protected $goodsTotalTax = 0.00;//税额
    protected $goodsTaxRate;//税率
    protected $goodsDiscountLineNo;//折行对应行号
    protected $priceTaxMark;// 含税标志0：不含税 1：含税
    protected $vatSpecialManagement;//增值税特殊管理
    protected $freeTaxMark;//“零税率标识：空代表无， 1 出口免税和其他免税优惠政策， 2 不征增值税， 3 普通零税率"
    protected $preferentialMark;//是否使用优惠政策 0:未使用，1:使用

    /**
     * @return mixed
     */
    public function getGoodsLineNo()
    {
        return $this->goodsLineNo;
    }

    /**
     * @param mixed $goodsLineNo
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsLineNo($goodsLineNo)
    {
        $this->goodsLineNo = $goodsLineNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsLineNature()
    {
        return $this->goodsLineNature;
    }

    /**
     * @param mixed $goodsLineNature
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsLineNature($goodsLineNature)
    {
        $this->goodsLineNature = $goodsLineNature;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsCode()
    {
        return $this->goodsCode;
    }

    /**
     * @param mixed $goodsCode
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsCode($goodsCode)
    {
        $this->goodsCode = $goodsCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsExtendCode()
    {
        return $this->goodsExtendCode;
    }

    /**
     * @param mixed $goodsExtendCode
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsExtendCode($goodsExtendCode)
    {
        $this->goodsExtendCode = $goodsExtendCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsName()
    {
        return $this->goodsName;
    }

    /**
     * @param mixed $goodsName
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsName($goodsName)
    {
        $this->goodsName = $goodsName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsTaxItem()
    {
        return $this->goodsTaxItem;
    }

    /**
     * @param mixed $goodsTaxItem
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsTaxItem($goodsTaxItem)
    {
        $this->goodsTaxItem = $goodsTaxItem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsSpecification()
    {
        return $this->goodsSpecification;
    }

    /**
     * @param mixed $goodsSpecification
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsSpecification($goodsSpecification)
    {
        $this->goodsSpecification = $goodsSpecification;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsUnit()
    {
        return $this->goodsUnit;
    }

    /**
     * @param mixed $goodsUnit
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsUnit($goodsUnit)
    {
        $this->goodsUnit = $goodsUnit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsQuantity()
    {
        return $this->goodsQuantity;
    }

    /**
     * @param mixed $goodsQuantity
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsQuantity($goodsQuantity)
    {
        $this->goodsQuantity = $goodsQuantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getGoodsPrice()
    {
        return $this->goodsPrice;
    }

    /**
     * @param float $goodsPrice
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsPrice($goodsPrice)
    {
        $this->goodsPrice = $goodsPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getGoodsTotalPrice()
    {
        return $this->goodsTotalPrice;
    }

    /**
     * @param float $goodsTotalPrice
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsTotalPrice($goodsTotalPrice)
    {
        $this->goodsTotalPrice = $goodsTotalPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getGoodsTotalTax()
    {
        return $this->goodsTotalTax;
    }

    /**
     * @param float $goodsTotalTax
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsTotalTax($goodsTotalTax)
    {
        $this->goodsTotalTax = $goodsTotalTax;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsTaxRate()
    {
        return $this->goodsTaxRate;
    }

    /**
     * @param mixed $goodsTaxRate
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsTaxRate($goodsTaxRate)
    {
        $this->goodsTaxRate = $goodsTaxRate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsDiscountLineNo()
    {
        return $this->goodsDiscountLineNo;
    }

    /**
     * @param mixed $goodsDiscountLineNo
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setGoodsDiscountLineNo($goodsDiscountLineNo)
    {
        $this->goodsDiscountLineNo = $goodsDiscountLineNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceTaxMark()
    {
        return $this->priceTaxMark;
    }

    /**
     * @param mixed $priceTaxMark
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setPriceTaxMark($priceTaxMark)
    {
        $this->priceTaxMark = $priceTaxMark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVatSpecialManagement()
    {
        return $this->vatSpecialManagement;
    }

    /**
     * @param mixed $vatSpecialManagement
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setVatSpecialManagement($vatSpecialManagement)
    {
        $this->vatSpecialManagement = $vatSpecialManagement;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFreeTaxMark()
    {
        return $this->freeTaxMark;
    }

    /**
     * @param mixed $freeTaxMark
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setFreeTaxMark($freeTaxMark)
    {
        $this->freeTaxMark = $freeTaxMark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreferentialMark()
    {
        return $this->preferentialMark;
    }

    /**
     * @param mixed $preferentialMark
     *
     * @return InvoiceDetailsRequestVO
     */
    public function setPreferentialMark($preferentialMark)
    {
        $this->preferentialMark = $preferentialMark;

        return $this;
    }

}