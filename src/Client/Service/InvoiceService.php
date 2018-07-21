<?php

use CoreOpenApi\Config\Config;
use InvoiceOpenApi\Api\InvoiceService as OpenInoiceService;
use InvoiceOpenApi\Protocol\InvoiceClient;

/**
 * 发票服务
 * @author wang
 */
class InvoiceService
{
    const INVOICE_TYPE_RED = 1;
    const INVOICE_TYPE_BLUE = 0;
    const GOODS_TYPE_GIFT = 2;

    //订单开票聚合
    const DEVICE_TYPE_DISK = 1;//税控盘

    const OPEN_INVOCIE_ERR_EMPTY_INVOICE = -1000;//没有空白发票
    const OPEN_INVOCIE_ERR_EMPTY_GOODS = -1001;//没有商品列表
    const OPEN_INVOCIE_ERR_GOODS_UPDATE = -1002;//goodsList冗余失败
    const OPEN_INVOCIE_ERR_DUP = -1003;//已经开过发票，不允许再开
    const OPEN_INVOCIE_ERR_TYPE = -1004;//开票类型不对
    const OPEN_INVOCIE_ERR_MONEY = -1005;//金额为0 不需要开票
    const OPEN_INVOCIE_ERR_MONEY2 = -1006;//金额计算错误 不可以开票
    const PROCESS_SUCCESS = '0000';

    static $config = []; //配置项

    public static function init($config)
    {
        if (empty(self::$config))
        {
            self::$config = $config;
        }
    }

    /**
     * 是否为蓝票
     *
     * @param int $type
     *
     * @return bool
     */
    public static function isOpenBlueInovice($type)
    {
        return $type == InvoiceUserDetail::TYPE_BLUE;
    }

    /**
     * 是否为红票
     *
     * @param int $type
     *
     * @return bool
     */
    public static function isOpenRedInovice($type)
    {
        return $type == InvoiceUserDetail::TYPE_RED;
    }

    /**
     * 根据invoiceUserDetail 信息开票
     *
     * @param InvoiceUserDetail $userDetail
     *
     * @return bool|mixed
     */
    public static function openInvoiceByDetail(InvoiceUserDetail &$userDetail)
    {
        /**
         * @var OpenInoiceService $invoiceservice
         * @var Config            $configObj
         */
        list($invoiceservice, $configObj) = self::getOpenInvoiceServiceAndConfig();

        if ($userDetail->invoice_no && $userDetail->invoice_code)
        {
            return ['code' => self::OPEN_INVOCIE_ERR_DUP, 'msg' => '重复开票'];
        }

        //查看空白发票数量start
        $emptyInoviceCount = self::getEmptyInvoiceNumber();

        if ($emptyInoviceCount < 1)
        { //没有空白发票 直接返回false
            FLog::log([
                'method'            => __METHOD__,
                'msg'               => '没有空白发票,需要先补充空白发票方可再次开票',
                'invoiceUserDetail' => $userDetail->attributes(),
                'result'            => false,
            ]);

            return ['code' => self::OPEN_INVOCIE_ERR_EMPTY_INVOICE, '没有空白发票,需要先补充空白发票方可再次开票'];
        }
        //查看空白发票数量 end

        if (self::isOpenBlueInovice($userDetail->type))
        { //蓝票
            $goodsList = self::getGoodsListByDetailForBlueInovice($userDetail->goods, $userDetail->tax_cates);
        }
        else
        { //红票
            $goodsList = self::getGoodsListByDetailForRedInovice($userDetail);
        }

        if ($goodsList)
        {
            $formatedInfo = self::formatOpenInoviceInfo($userDetail, $goodsList, $configObj);
            if (self::isOpenBlueInovice($userDetail->type) && $formatedInfo->getInvoiceTotalPriceTax() == 0)
            { //金额为0 不需要开蓝票
                FLog::log([
                    'method'            => __METHOD__,
                    'msg'               => '开票失败:金额为0 不需要开票',
                    'formatedInfo'      => $formatedInfo->getData(),
                    'invoiceUserDetail' => $userDetail->attributes(),
                    'result'            => '',
                ]);

                return ['code' => self::OPEN_INVOCIE_ERR_MONEY, '开票失败:金额为0 不需要开票'];
            }

            //发起开票请求
            $result = $invoiceservice->openInvoice($formatedInfo);

            if (isset($result['code']) && $result['code'] == self::PROCESS_SUCCESS)
            { //请求成功 设置状态
                $userDetail->status          = InvoiceUserDetail::STATUS_SUCCESS;
                $userDetail->invoice_no      = $result['data']['invoiceNo'];
                $userDetail->invoice_code    = $result['data']['invoiceCode'];
                $userDetail->total_price_tax = $formatedInfo->getInvoiceTotalPriceTax();
                $userDetail->total_price     = $formatedInfo->getInvoiceTotalPrice();
                $userDetail->total_tax       = $formatedInfo->getInvoiceTotalTax();
                $userDetail->make_time       = time();
                $userDetail->update_time     = time();
                $userDetail->updateFields([
                    'status',
                    'invoice_no',
                    'invoice_code',
                    'total_price_tax',
                    'total_price',
                    'total_tax',
                    'money',
                    'make_time',
                    'update_time',
                ]);

                self::beforeReturn($result);//尝试刷新token

                //修改缓存的空白发票数量
                self::updateEmptyInvoiceLeftNum(-1);
            }
            else
            { //请求失败
                FLog::log([
                    'method'            => __METHOD__,
                    'msg'               => '开票失败',
                    'formatedInfo'      => $formatedInfo->getData(),
                    'invoiceUserDetail' => $userDetail->attributes(),
                    'result'            => $result,
                ]);
            }

            return $result;
        }
        else
        {
            FLog::log([
                'method'            => __METHOD__,
                'msg'               => 'goodsList获取失败',
                'invoiceUserDetail' => $userDetail->attributes(),
            ]);
            $result = ['code' => self::OPEN_INVOCIE_ERR_EMPTY_GOODS, 'goodsList获取失败'];
        }

        return $result;
    }

    /**
     * 格式化商品列表
     * （整合商品及其税收大类，算计商品的总价税额，折扣税额 方便后续操作）
     *
     * @param array $goodsList   待整合的商品列表
     * @param array $taxCateList 对应的税收大类相关信息(包含税收大类名字，税率，税收编码)
     *
     * @return array
     */
    public static function formatGoodsList($goodsList, $taxCateList)
    {
        foreach ($goodsList as &$goods)
        {
            $priceTaxMark = 1;//价格是否含税标识  0:不含税 1：含税
            if (isset($goods['price_tax_mark']))
            {//有设置 price_tax_mark
                $priceTaxMark = $goods['price_tax_mark'];
            }
            $goodsTaxCateId     = isset($goods['tax_category']) ? $goods['tax_category'] : 0;
            $taxCateRate        = 0;
            $taxCateName        = '';
            $taxCateCode        = '';
            $taxCateDisplayName = '';
            if (isset($taxCateList[$goodsTaxCateId]) && $taxCateList[$goodsTaxCateId])
            {
                $taxCateRate        = CommonHelper::toMoney($taxCateList[$goodsTaxCateId]['rate'] / 100.0);
                $taxCateName        = $taxCateList[$goodsTaxCateId]['name'];
                $taxCateCode        = $taxCateList[$goodsTaxCateId]['code'];
                $taxCateDisplayName = $taxCateList[$goodsTaxCateId]['invoice_name'];
                if (empty($taxCateDisplayName))
                {
                    $taxCateDisplayName = $taxCateName;
                }
            }

            if ($goods['type'] == self::GOODS_TYPE_GIFT)
            { //赠品和优惠券 先修改total_price的值
                $totalPrice           = $goods['count'] * $goods['price'];
                $goods['total_price'] = CommonHelper::toMoney($totalPrice);
            }

            if ($taxCateRate == 0)
            { //免税
                $goods['free_tax_mark']          = '1';
                $goods['preferential_mark']      = '1';
                $goods['vat_special_management'] = '免税';
            }
            else
            {
                $goods['vat_special_management'] = '';
                $goods['free_tax_mark']          = '';
                $goods['preferential_mark']      = '0';
            }

            //根据total_price计算税额
            $totalTax = self::getTaxByPriceTaxMark($goods['total_price'], $taxCateRate, $priceTaxMark);
            $totalTax = CommonHelper::toMoney($totalTax);

            //计算商品折扣价和折扣税额
            $discountPrice = $goods['discount_price'];
            $discountTax   = self::getTaxByPriceTaxMark($discountPrice, $taxCateRate, $priceTaxMark);
            //获得商品折扣类型
            $discountType = self::getDiscountType($goods, $discountPrice);

            $goods['discount_type']     = $discountType;
            $goods['price_tax_mark']    = $priceTaxMark;
            $goods['tax_rate']          = $taxCateRate;
            $goods['tax_category_name'] = $taxCateName;
            $goods['tax_display_name']  = $taxCateDisplayName;
            $goods['group_by_mark']     = $taxCateDisplayName . ':' . $taxCateRate; //分组标识 (根据税收大类描述和税率分组)
            $goods['tax_code']          = $taxCateCode;
            $goods['discount_tax']      = CommonHelper::toFixedFloat($discountTax);
            $goods['total_price']       = CommonHelper::toFixedFloat($goods['total_price']);
            $goods['total_price_tax']   = $totalTax;
            $goods['total_tax']         = $totalTax;
            $goods['discount_price']    = $discountPrice;
        }

        return $goodsList;
    }

    /**
     * 根据orderIds获得所有需要开票的数据（没有格式化）
     *
     *
     * @return array
     */
    public static function getGoodsListByDetailForBlueInovice($goodsList, $taxCateList)
    {
        //格式化goods列表（整合商品及其税收大类，算计商品的总价税额，折扣税额 方便后续操作）
        $goodsList = self::formatGoodsList($goodsList, $taxCateList);

        $goodsList = self::formatGoodsInfoForBlueInvoice($goodsList);

        return $goodsList;
    }

    /**
     * 开红票 获得开票商品相关信息
     *
     * @param InvoiceUserDetail $invoiceUserDetail
     *
     * @return array|mixed
     */
    public static function getGoodsListByDetailForRedInovice(InvoiceUserDetail $invoiceUserDetail)
    {
        //对应蓝票的开票记录
        $oldUserDetail = InvoiceUserDetail::getById($invoiceUserDetail->ori_invoice_id);
        $goodsList     = $oldUserDetail->goods;
        $taxCateList   = $oldUserDetail->tax_cates;
        //格式化goods列表（整合商品及其税收大类，算计商品的总价税额，折扣税额 方便后续操作）
        $goodsList = self::formatGoodsList($goodsList, $taxCateList);

        $goodsList = self::formatGoodsInfoForRedInvoice($goodsList);

        return $goodsList;
    }

    /**
     * 根据价格是否含税，来计算税额
     *
     * @param float $totalPrice   价格
     * @param float $taxCateRate  税率
     * @param int   $priceTaxMark 价格是否含税 0：不含税 1：含税
     *
     * @return float|int
     */
    public static function getTaxByPriceTaxMark($totalPrice, $taxCateRate, $priceTaxMark = 1)
    {
        if ($priceTaxMark == 1)
        { //商品价格含税 税额 = 总价 / (1+税率)  * 税率
            return $totalPrice / (1 + $taxCateRate) * $taxCateRate;
        }
        else
        {//商品价格不含税 税额 = 总价 * 税率
            return $totalPrice * $taxCateRate;
        }
    }

    /**
     * 当前是否为折扣行
     *
     * @param array $goodsInfo     商品信息
     * @param int   $discountPrice 折扣价格
     *
     * @return int
     */
    public static function getDiscountType($goodsInfo, $discountPrice = 0)
    {
        if ($goodsInfo['type'] == self::GOODS_TYPE_GIFT)
        {//赠品
            return 2;
        }
        if (empty($discountPrice))
        {
            $discountPrice = $goodsInfo['discount_price'];//折扣价格
        }
        if ($discountPrice > 0)
        {//有优惠价格
            return 1;
        }

        return 0;
    }

    /**
     * 构建折扣行商品
     *
     * @param array $goods       商品信息
     * @param int   $goodsLineNo 当前商品行
     *
     * @return array
     */
    public static function buildDiscountGoodsInfo($goods, $goodsLineNo)
    {
        $goods['goods_line_no']     = $goodsLineNo + 1;
        $goods['discount_line_no']  = $goodsLineNo;
        $goods['goods_line_nature'] = '1';
        if ($goods['discount_type'] == 1)
        { //各种价格优惠
            $goods['total_price'] = $goods['discount_price'];
            $goods['total_tax']   = $goods['discount_tax'];
        }

        return $goods;
    }

    /**
     * 格式化商品信息 (for蓝票)
     *
     * @param array $goodsList 商品列表
     *
     * @return array
     */
    public static function formatGoodsInfoForBlueInvoice($goodsList)
    {
        $goodsLineNo  = 1;
        $goodsNum     = count($goodsList);
        $newGoodsList = [];
        for ($index = 0; $index < $goodsNum; $index++)
        {
            $goods                  = $goodsList[$index];
            $goods['goods_line_no'] = $goodsLineNo;//当前商品行号

            $lineNature = 0;//发票行性质，0：正常行 1：折扣行 2：被折扣行
            if ($goods['discount_type'] > 0)
            {
                $lineNature = 2;//当前行为被折扣行
            }
            $goods['goods_line_nature'] = $lineNature;//行性质

            $newGoodsList[$goodsLineNo] = $goods;//添加当前行

            if ($lineNature == 2)
            { //当前行 为折扣行，添加被折扣行信息
                $lastGoodsLineNo              = $goodsLineNo;
                $newGoodsList[++$goodsLineNo] = self::buildDiscountGoodsInfo($goods, $lastGoodsLineNo);//新增折扣行
            }
            $goodsLineNo++;
        }

        return $newGoodsList;
    }


    /**
     * 格式化商品信息 (for红票)
     *
     * @param array $goodsList
     *
     * @return mixed
     */
    public static function formatGoodsInfoForRedInvoice($goodsList)
    {
        $goodsLineNo  = 1;
        $goodsNum     = count($goodsList);
        $newGoodsList = [];
        for ($index = 0; $index < $goodsNum; $index++)
        {
            $goods = $goodsList[$index];
            if ($goods['type'] == 2 || $goods['type'] == 3)
            { //赠品和优惠券 先修改total_price的值
                continue;
            }

            $goods['goods_line_no'] = $goodsLineNo;

            $goods['goods_line_nature'] = 0;//行性质
            if ($goods['discount_type'] > 0)
            { //当前为被折扣行，重新计算 total_price, price和total_tax
                $totalTax = $goods['discount_tax'];

                $finalTotalPrice      = $goods['total_price'] - $goods['discount_price'];
                $finalTotalPrice      = CommonHelper::toFixedFloat($finalTotalPrice, 2);
                $finalTotalTax        = $goods['total_tax'] - $totalTax;
                $finalTotalTax        = CommonHelper::toFixedFloat($finalTotalTax, 2);
                $finalPrice           = $finalTotalPrice / $goods['count'];
                $finalPrice           = CommonHelper::toFixedFloat($finalPrice, 2);
                $goods['total_tax']   = $finalTotalTax; //税额 = (总价 / (1 + 税率) * 税率) - 折扣税额
                $goods['total_price'] = $finalTotalPrice; //总价 = 总价 - 折扣价
                $goods['price']       = $finalPrice; //单价 = （总价 - 折扣价）/数量
                if ($finalPrice == 0)
                {// 折扣完了 直接无视
                    continue;
                }
            }
            $newGoodsList[$goodsLineNo] = $goods;
            $goodsLineNo++;
        }

        return $newGoodsList;
    }

    /**
     * @param array $goods
     *
     * @return \InvoiceOpenApi\VO\InvoiceDetailsRequestVO
     */
    public static function fillCommonInvoiceDetailVO($goods)
    {
        $vo = new \InvoiceOpenApi\VO\InvoiceDetailsRequestVO();
        $vo->setGoodsLineNo($goods['goods_line_no']);
        if (isset($goods['discount_line_no']) && $goods['discount_line_no'])
        {
            $vo->setGoodsDiscountLineNo($goods['discount_line_no']);
        }
        $vo->setGoodsName($goods['product_name']);

        if (isset($goods['price']) && $goods['price'] > 0 && $goods['goods_line_nature'] != 1)
        {//折扣行不显示单价,价格为0不显示单价
            $vo->setGoodsPrice($goods['price']);//商品单价
        }

        $vo->setPriceTaxMark($goods['price_tax_mark']);//含税标识 0：不含税， 1:含税
        $vo->setGoodsLineNature($goods['goods_line_nature']);//发票行性质，0：正常行 1：折扣行 2：被折扣行

        if (isset($goods['tax_rate']))
        {
            $vo->setGoodsTaxRate($goods['tax_rate']);//税率
        }
        if (isset($goods['tax_code']))
        {
            $vo->setGoodsCode($goods['tax_code']);
        }

        $vo->setPreferentialMark($goods['preferential_mark']);//是否使用优惠政策 0:未使用，1:使用
        if ($goods['vat_special_management'])
        {
            $vo->setVatSpecialManagement($goods['vat_special_management']);
        }
        if (isset($goods['free_tax_mark']) && $goods['free_tax_mark'])
        {
            $vo->setFreeTaxMark($goods['free_tax_mark']);//零税率标识：空代表无， 1 出口免税和其他免税优惠政策
        }

        return $vo;
    }

    /**
     * @param array $goods
     *
     * @return \InvoiceOpenApi\VO\InvoiceDetailsRequestVO
     */
    public static function fillDetailVOForBlueInvoice(&$goods)
    {
        $vo = self::fillCommonInvoiceDetailVO($goods);
        if ($goods['goods_line_nature'] == 1)
        { //折扣行 商品总价和商品税额为负数
            $goods['total_price'] = '-' . $goods['total_price'];
            $vo->setGoodsTotalPrice($goods['total_price']);//商品总价

            if (isset($goods['total_tax']))
            {
                $goods['total_tax'] = '-' . $goods['total_tax'];
                $vo->setGoodsTotalTax($goods['total_tax']);//税额
            }
        }
        else
        { //正常行或者被折扣行 商品总价和商品税额是正数
            $vo->setGoodsTotalPrice($goods['total_price']);//商品总价
            if (isset($goods['total_tax']))
            {
                $vo->setGoodsTotalTax($goods['total_tax']);//税额
            }
            if (isset($goods['count']) && $goods['count'] > 0)
            {
                $vo->setGoodsQuantity($goods['count']);//商品数量
            }
            $vo->setGoodsUnit($goods['unit']);
        }

        return $vo;
    }

    /**
     * @param array $goods
     *
     * @return \InvoiceOpenApi\VO\InvoiceDetailsRequestVO
     */
    public static function fillDetailVOForRedInvoice($goods)
    {
        $vo = self::fillCommonInvoiceDetailVO($goods);
        $vo->setGoodsTotalPrice('-' . $goods['total_price']);
        $vo->setGoodsQuantity('-' . $goods['count']);
        if (isset($goods['total_tax']))
        {
            $vo->setGoodsTotalTax('-' . $goods['total_tax']);//税额
        }

        return $vo;
    }

    /**
     * 获取序列号
     *
     * @param InvoiceUserDetail $invoiceUserDetail
     *
     * @return string
     */
    public static function getSerialNo(InvoiceUserDetail $invoiceUserDetail)
    {
        $serialNo = $invoiceUserDetail->serial_no;
        if (empty($serialNo))
        {
            $serialNo = $invoiceUserDetail->_id();
            if ($invoiceUserDetail->type)
            {
                $serialNo .= 'red';
            }
            else
            {
                $serialNo .= 'blue';
            }

            return $serialNo;
        }

        return $serialNo;
    }

    /**
     * @param InvoiceUserDetail $invoiceUserDetail
     * @param Config            $configObj
     * @param array             $goodsDetailList
     *
     * @return \InvoiceOpenApi\VO\OpenInvoiceRequestVO
     */
    public static function fillCommonInvoiceVO(
        InvoiceUserDetail $invoiceUserDetail,
        Config $configObj,
        $goodsDetailList
    ) {

        $vo       = new \InvoiceOpenApi\VO\OpenInvoiceRequestVO();
        $serialNo = self::getSerialNo($invoiceUserDetail);
        $vo->setSerialNo($serialNo);//开票流水
        $vo->setBuyerName($invoiceUserDetail->invoice_title);//开票title
        if ($invoiceUserDetail->ein)
        {//开票税号
            $vo->setBuyerTaxNo($invoiceUserDetail->ein);
        }
        $vo->setTaxationMode($configObj->getParamByKey('taxationMode'));//征税方式: 普通征税
        $vo->setInvoiceTypeCode($configObj->getParamByKey('invoiceTypeCode'));//发票种类编码
        $vo->setSellerTaxNo($configObj->getParamByKey('sellerTaxNo'));//公司税号
        $vo->setInvoiceTerminalCode($configObj->getParamByKey('invoiceTerminalCode'));//开票点编码
        $vo->setInvoiceSpecialMark("00");//特殊票种标记，00：普通发票 02：农业发票 默认：00
        $vo->setDrawer($configObj->getParamByKey('drawer'));//开票人
        $vo->setChecker($configObj->getParamByKey('checker'));//复核人
        $vo->setPayee($configObj->getParamByKey('payee'));//收款人
        $vo->setInvoiceType($invoiceUserDetail->type);//开票类型 0:正数发票（蓝票） 1：负数发票（红票）

        $deviceType = $configObj->getParamByKey('deviceType');
        $vo->setDeviceType($deviceType);
        if ($deviceType == self::DEVICE_TYPE_DISK)
        {
            $vo = self::fillDiviceTypeDiskInfo($configObj, $vo);
        }
        $vo->setInvoiceDetailsList($goodsDetailList);

        return $vo;
    }

    /**
     * @param InvoiceUserDetail $invoiceUserDetail
     * @param Config            $configObj
     * @param float             $totalPrice
     * @param float             $totalPriceTax
     * @param float             $totalTax
     *
     * @return \InvoiceOpenApi\VO\OpenInvoiceRequestVO
     */
    public static function fillBlueInvoiceVO(
        InvoiceUserDetail $invoiceUserDetail,
        Config $configObj,
        $goodsDetailList,
        $totalPrice,
        $totalPriceTax,
        $totalTax
    ) {
        //公用部分
        $vo = self::fillCommonInvoiceVO($invoiceUserDetail, $configObj, $goodsDetailList);
        //蓝票特殊处理部分
        $vo->setInvoiceTotalPrice(CommonHelper::toMoney($totalPrice));
        $vo->setInvoiceTotalPriceTax(CommonHelper::toMoney($totalPriceTax));
        $vo->setInvoiceTotalTax(CommonHelper::toMoney($totalTax));

        return $vo;
    }

    /**
     * @param InvoiceUserDetail $invoiceUserDetail
     * @param Config            $configObj
     * @param float             $totalPrice
     * @param float             $totalPriceTax
     * @param float             $totalTax
     *
     * @return \InvoiceOpenApi\VO\OpenInvoiceRequestVO
     */
    public static function fillRedInvoiceVO(
        InvoiceUserDetail $invoiceUserDetail,
        Config $configObj,
        $goodsDetailList,
        $totalPrice,
        $totalPriceTax,
        $totalTax
    ) {

        //公用部分
        $vo = self::fillCommonInvoiceVO($invoiceUserDetail, $configObj, $goodsDetailList);

        //红票特殊处理部分
        $vo->setInvoiceTotalPrice('-' . CommonHelper::toMoney($totalPrice));
        $vo->setInvoiceTotalPriceTax('-' . CommonHelper::toMoney($totalPriceTax));
        $vo->setInvoiceTotalTax('-' . CommonHelper::toMoney($totalTax));
        $vo->setOriginalInvoiceCode($invoiceUserDetail->ori_invoice_code);//原票代码
        $vo->setOriginalInvoiceNo($invoiceUserDetail->ori_invoice_no);//原票号码

        return $vo;
    }

    /**
     * 格式化所有需要开票的数据
     *
     * @param InvoiceUserDetail $invoiceUserDetail
     * @param array             $goodsList
     * @param Config            $configObj
     *
     * @return \InvoiceOpenApi\VO\OpenInvoiceRequestVO|null
     */
    public static function formatOpenInoviceInfo(InvoiceUserDetail $invoiceUserDetail, $goodsList, $configObj)
    {
        $vo              = null;
        $goodsDetailList = [];
        $totalTax        = 0.0;
        $totalPrice      = 0.0;
        $totalPriceTax   = 0.0;
        $goodsUnit       = $configObj->getParamByKey('goodsUnit');
        foreach ($goodsList as &$goods)
        {
            if (!isset($goods['unit']))
            {
                $goods['unit'] = $goodsUnit;
            }

            if (self::isOpenBlueInovice($invoiceUserDetail->type))
            {//蓝票
                $goodsDetailList[] = self::fillDetailVOForBlueInvoice($goods);
            }
            else
            {//红票
                $goodsDetailList[] = self::fillDetailVOForRedInvoice($goods);
            }

            if ($goods['price_tax_mark'] == 0)
            { //不含税
                $totalPriceTax += $goods['total_tax'] + $goods['total_price'];
            }
            else
            {//含税
                $totalPriceTax += $goods['total_price'];
            }
            $totalTax   += $goods['total_tax'];
            $totalPrice += $goods['total_price'];
        }
        $totalPriceTax = $totalPrice;
        $totalPrice    = $totalPrice - $totalTax;
        if (self::isOpenBlueInovice($invoiceUserDetail->type))
        { //蓝票
            $vo = self::fillBlueInvoiceVO($invoiceUserDetail, $configObj, $goodsDetailList, $totalPrice, $totalPriceTax,
                $totalTax);
        }
        else
        {//红票
            $vo = self::fillRedInvoiceVO($invoiceUserDetail, $configObj, $goodsDetailList, $totalPrice, $totalPriceTax,
                $totalTax);
        }

        return $vo;
    }

    /**
     * 更新缓存的空白发票数量
     *
     * @param $step
     *
     * @return int
     */
    public static function updateEmptyInvoiceLeftNum($step)
    {
        if ($step > 0)
        {
            return RedisHelper::getInstance()->incrBy(self::getInvoiceStockKey(), $step);
        }
        else
        {
            return RedisHelper::getInstance()->decrBy(self::getInvoiceStockKey(), $step);
        }
    }

    /**
     * 获得剩余发票张数
     * @return int
     */
    public static function getEmptyInvoiceNumber()
    {
        $cachedCount = RedisHelper::getInstance()->get(self::getInvoiceStockKey());
        if ($cachedCount > 10)
        {
            return $cachedCount;
        }

        $result = self::purchaseQuery();
        if (isset($result['code']) && $result['code'] == self::PROCESS_SUCCESS)
        { //返回成功
            //剩余数量
            $leftTotalCount = isset($result['data']['invoiceSurplusTotalQuantity']) ? $result['data']['invoiceSurplusTotalQuantity'] : 0;
            $count          = max(0, $leftTotalCount);//剩余空白发票数量
            RedisHelper::getInstance()->setex(self::getInvoiceStockKey(), 3600, $count);//缓存一个小时

            return $count;
        }
        else
        { //返回失败
            FLog::log(['method' => __METHOD__, 'result' => $result]);

            return -1;//报错
        }
    }

    /**
     * @param Config                           $config
     * @param \InvoiceOpenApi\VO\InvoiceBaseVO $vo
     *
     * @return \InvoiceOpenApi\VO\InvoiceBaseVO
     */
    public static function fillDiviceTypeDiskInfo(Config $config, \InvoiceOpenApi\VO\InvoiceBaseVO $vo)
    {
        $vo->setTaxDiskKey($config->getParamByKey('taxDiskKey'))->setTaxDiskNo($config->getParamByKey('taxDiskNo'))->setTaxDiskPassword($config->getParamByKey('taxDiskPassword'));

        return $vo;
    }

    public static function getInvoiceStockKey()
    {
        return RedisKey::INVOICE_STOCK;
    }

    /**
     * 生成版式文件（pdf）
     *
     * @param InvoiceUserDetail $userDetail
     *
     * @return mixed
     */
    public static function formatFileBuild(InvoiceUserDetail $userDetail)
    {
        /**
         * @var OpenInoiceService $invoiceservice
         * @var Config            $configObj
         */
        list($invoiceservice, $configObj) = self::getOpenInvoiceServiceAndConfig();
        $vo       = new \InvoiceOpenApi\VO\FormatfileBuildRequestVO();
        $serialNo = self::getSerialNo($userDetail);
        $vo->setSellerTaxNo($configObj->getParamByKey('sellerTaxNo'));
        $vo->setSerialNo($serialNo)->setPushType("0");
        $result = $invoiceservice->formatFileBuild($vo);
        FLog::log(['method' => __METHOD__, 'result' => $result]);
        if (isset($result['code']) && $result['code'] == self::PROCESS_SUCCESS)
        { //请求成功 设置状态
            $pdfUrl = $result['data']['data'];
            FLog::log(['method' => __METHOD__, 'serialNo' => $serialNo, 'result' => $result]);

            $data['upate_time'] = time();
            $data['down_url']   = $pdfUrl;

            InvoiceUserDetail::updateById($userDetail->_id(), $data);

            self::beforeReturn($result);//尝试刷新token

            return $result;
        }
        else
        { //请求失败
            FLog::log(['method' => __METHOD__, 'result' => $result]);

            return $result;
        }
    }

    /**
     * 公司查询
     *
     * @param string $companyName 公司名称
     * @param string $taxId       公司税号
     * @param string $accuracy    是否精确查找, "true":精确查找 "false": 模糊查找
     *
     * @return mixed
     */
    public static function companySearch($companyName, $taxId = '', $accuracy = 'false')
    {
        /**
         * @var OpenInoiceService $invoiceservice
         */
        list($invoiceservice, $configObj) = self::getOpenInvoiceServiceAndConfig();

        $vo = new \InvoiceOpenApi\VO\CompanySearchRequestVO();
        $vo->setCompanyName($companyName);
        if ($accuracy)
        {
            $vo->setAccuracy($accuracy);
        }
        if ($taxId)
        {
            $vo->setTaxId($taxId);
        }

        return $invoiceservice->companySearch($vo);
    }

    /**
     * 查询剩余发票数量
     * @return mixed
     */
    public static function purchaseQuery()
    {
        /**
         * @var OpenInoiceService $invoiceservice
         * @var Config            $configObj
         */
        list($invoiceservice, $configObj) = self::getOpenInvoiceServiceAndConfig();
        $deviceType = $configObj->getParamByKey('deviceType');
        $vo         = new \InvoiceOpenApi\VO\PurchaseQueryRequestVO();
        $vo->setDeviceType($deviceType);
        $vo->setSellerTaxNo($configObj->getParamByKey('sellerTaxNo'));
        $vo->setInvoiceTerminalCode($configObj->getParamByKey('invoiceTerminalCode'));
        $vo->setMachineNo($configObj->getParamByKey('machineNo'));
        $vo->setInvoiceTypeCode($configObj->getParamByKey('invoiceTypeCode'));
        if ($deviceType == self::DEVICE_TYPE_DISK)
        {
            $vo = self::fillDiviceTypeDiskInfo($configObj, $vo);
        }

        return $invoiceservice->purchaseQuery($vo);
    }


    /**
     * @param $return
     */
    public static function beforeReturn($return)
    {
        if (isset($return['autoFreshTokenResp']))
        {
            self::refreshToken($return['autoFreshTokenResp']['response']);
        }
    }

    /**
     * 刷新token
     *
     * @param $response
     */
    public static function refreshToken($response)
    {
        RedisHelper::getInstance()->setex(RedisKey::OPEN_INVOICE_TOKEN, $response['expires_in'] - 60,
            $response['access_token']);
    }

    /**
     * 删除token缓存
     */
    public static function deleteCachedToken()
    {
        RedisHelper::getInstance()->del(RedisKey::OPEN_INVOICE_TOKEN);
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getOpenInvoiceServiceAndConfig()
    {
        if (empty(self::$config))
        {
            throw new Exception('请先init再使用!');
        }
        $configObj = new Config(self::$config);
        $token     = RedisHelper::getInstance()->get(RedisKey::OPEN_INVOICE_TOKEN);
        $client    = new InvoiceClient($token, $configObj);
        if (empty($token))
        {
            $tokenInfo = $client->getToken($configObj);
            if (isset($tokenInfo['token']))
            {
                $token = $tokenInfo['token'];
                $client->setToken($token);
                $response = $tokenInfo['response']['response'];
                self::refreshToken($response);
            }
        }
        //使用config和token对象，实例化一个服务对象
        $invoiceservice = new OpenInoiceService($client);

        return [$invoiceservice, $configObj];
    }

}