<?php

/**
 * 用户开票资料
 * Class InvoiceUserDetail
 */
class InvoiceUserDetail
{
    //发票类型
    const TYPE_BLUE = 0;    //蓝字发票(正)
    const TYPE_RED = 1;     //红字发票（负）
    public static $typeOption = [
        self::TYPE_BLUE => '蓝字发票',
        self::TYPE_RED  => '红字发票',
    ];
    //状态
    const STATUS_INIT = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 2;
    const STATUS_INVALID = 3;
    public static $resultStatus = array(
        self::STATUS_INIT    => '开票中',
        self::STATUS_SUCCESS => '成功',
        self::STATUS_FAIL    => '失败',
        self::STATUS_INVALID => '无须开票',
    );

    public $_id;                        //  id  开票流水号
    public $serial_no;                  //开票流水
    public $apply_id;                   //用户申请ID
    public $user_id;                    //用户ID
    public $mobile;                     //用户注册手机号
    public $type;                       //开票类型0蓝字发票1红字发票
    public $invoice_type;               //发票类型1个人2公司
    public $invoice_title;              //发票抬头
    public $ein;                        //税号(int)
    public $content_type;               //发票内容类型
    public $tax_price;                  //税额
    public $order_price;                //订单金额（开票金额）
    public $down_url;                   //发票下载链接
    public $invoice_no;                 //发票号码
    public $invoice_code;                //发票代码
    public $ori_invoice_no;              //原发票号码 开红票的时候 必须
    public $ori_invoice_code;            //原发票代码 开红票的时候 必须
    public $ori_invoice_id;              //原发票id 开红票的时候根据这个id获取对应的goods
    public $img_url;                    //发票图片地址
    public $img_w;                      //发票图片宽度
    public $img_h;                      //发票图片高度
    public $order_ids;                  //订单号列表
    public $send_mail;                  //发送邮箱
    public $send_mail_status;           //发送邮箱状态
    public $note = '';                    //备注
    public $make_time;                  //开票时间
    public $re_make_note;               //重新开票原因
    public $fail_note;                  //开票失败原因
    public $status;                     //状态
    public $goods;                      //开票的goodsList
    public $tax_cates;                  //开票的时候对应的谁
    public $error_info;                 //错误信息
    public $money;                      //可开票金额
    public $total_price;                //发票显示总额
    public $total_price_tax;            //发票显示总额+税额
    public $total_tax;                  //发票显示总税额
    public $create_time;                //创建时间
    public $update_uid;                 //更新人
    public $update_time;                //更新时间

    //开票
    public static function add($params, $type)
    {
        $obj                = new self();
        $obj->apply_id      = $params['_id'];
        $obj->user_id       = $params['user_id'];
        $obj->mobile        = $params['mobile'];
        $obj->type          = $type;
        $obj->invoice_type  = $params['invoice_type'];
        $obj->invoice_title = $params['invoice_title'];
        //如果为红票，记录原来发票信息
        if ($type == self::TYPE_RED)
        {
            $obj->ori_invoice_id   = $params['current_detail_id'];
            $obj->ori_invoice_no   = $params['invoice_no'];
            $obj->ori_invoice_code = $params['invoice_code'];
        }
        $obj->ein          = $params['ein'];
        $obj->content_type = $params['content_type'];
        $obj->tax_price    = $params['tax_price'];
        $obj->order_price  = $params['order_price'];
        $obj->order_ids    = $params['order_ids'];
        $obj->status       = self::STATUS_INIT;
        $obj->create_time  = time();
        $obj->update_time  = time();

        return null;
    }

    //详情
    public function formatData()
    {
        return [
            '_id'               => $this->_id,
            'serial_no'         => $this->serial_no,
            'mobile'            => $this->mobile,
            'apply_id'          => $this->apply_id,
            'invoice_type'      => $this->invoice_type ?: 1,
            'invoice_title'     => $this->invoice_title,
            'ein'               => $this->ein,
            'content_type'      => $this->content_type,
            'content_type_name' => $this->content_type ?: '',
            'type'              => $this->type,
            'type_name'         => self::$typeOption[$this->type] ?: '',
            'tax_price'         => CommonHelper::toMoney($this->tax_price),
            'order_price'       => CommonHelper::toMoney($this->order_price),
            'status'            => $this->status,
            'status_name'       => self::$resultStatus[$this->status] ?: '',
            'note'              => $this->note ?: '',
            'make_time'         => $this->make_time ?: 0,
            'create_time'       => $this->create_time,
            'img_url'           => $this->img_url ?: "",
            'img_w'             => $this->img_w ?: 0,
            'img_h'             => $this->img_h ?: 0,
            'down_url'          => $this->down_url ?: "",
            're_make_note'      => $this->re_make_note ?: "",
            'fail_note'         => $this->fail_note ?: "",
            'goods'             => $this->goods ?: "",
            'ori_invoice_id'    => $this->ori_invoice_id ?: "",
            'tax_cates'         => $this->tax_cates ?: "",
            'error_info'        => $this->error_info ?: "",
            'money'             => $this->money ?: 0,
            'total_price'       => $this->total_price ?: 0,
            'total_price_tax'   => $this->total_price_tax ?: 0,
            'total_tax'         => $this->total_tax ?: 0,
        ];
    }

    /**
     * todo 根据存储不同 自己实现
     *
     * @param $id
     * @param $data
     *
     * @return bool
     */
    public static function updateById($id, $data)
    {
        return true;
    }

    /**
     * todo 根据存储不同 自己实现
     *
     * @param $id
     *
     * @return InvoiceUserDetail
     */
    public static function getById($id)
    {
        return new InvoiceUserDetail();
    }

    public function _id()
    {
        return $this->_id;
    }

    public function attributes()
    {
        return $this->formatData();
    }

    /**
     * todo 根据存储不同 自己实现
     *
     * @param $update
     *
     * @return bool
     */
    public function updateFields($update)
    {
        return true;
    }
}