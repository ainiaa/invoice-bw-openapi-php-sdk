<?php

/**
 * 全局公共函数
 */
class CommonHelper
{
    /**
     * @param $money
     *
     * @return float (real string)
     */
    public static function toMoney($money, $num = 2)
    {
        //return round($money, 2);
        return sprintf('%.2f', round($money, $num));
    }

    /**
     * 舍去法金额
     *
     * @param $money
     *
     * @return string|float
     */
    public static function floorMoney($money)
    {
        return sprintf('%.2f', floor($money * 100) / 100);
    }

    // 转化为浮点格式(可自定义小数位)
    public static function toFloat($val, $num = 1)
    {
        return round($val, $num);
    }

    public static function toFixedFloat($val, $num = 2)
    {
        return sprintf('%.' . $num . 'f', round($val, $num));
    }
}
