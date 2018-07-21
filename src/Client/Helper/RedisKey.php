<?php

/**
 * redis key 统一定义处，防止各模块使用key冲突
 */
class RedisKey
{
    const OPEN_INVOICE_TOKEN = 'open_invoice_token'; //开票token缓存
    const OPEN_INVOICE_PENDING = 'open_invoice_pending';//等待开票队列
    const INVOICE_BUILD_FORMAT_FILE = 'invoice_build_format_file';//发票生成版式文件（pdf）
    const INVOICE_STOCK = 'invoice_stock';//开票剩余空白发票数量
}
