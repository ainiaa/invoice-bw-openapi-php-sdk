<?php

/**
 * 税收大类
 * Class InvoiceTaxCategory
 */
class InvoiceTaxCategory
{
    public $_id;
    public $code;           //编码
    public $name;           //名称
    public $invoice_name;   //发票显示名称
    public $desc = '';      //说明
    public $rate;           //税率
    public $status;         //状态
    public $create_uid;     //创建人
    public $create_time;    //创建时间
    public $update_uid;     //更新人
    public $update_time;    //更新时间

    //通用显示状态
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;

    /**
     * todo 根据存储不同 自己实现
     *
     * @param $ids
     * @param $fields
     *
     * @return array
     */
    public static function getByIds($ids, $fields)
    {
        return [];
    }
}