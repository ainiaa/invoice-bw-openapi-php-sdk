<?php

/**
 * summary: 文件log - 按模块
 */
class FLog
{
    /**
     * 记录日志
     *
     * @param        $value
     * @param string $level
     * @param string $fileName
     */
    public static function log($value, $level = 'info', $fileName = 'application.log')
    {
        $text = is_scalar($value) ? strval($value) : json_encode($value, JSON_UNESCAPED_UNICODE);

        //日志区分入口为报警类型频次判断使用
        if ($_SERVER['argv'][2] == 'show_log')
        {
            echo $msg = sprintf("[%s][%s] %s %s", $level, date('Y-m-d H:i:s'), $text, PHP_EOL);
        }

        error_log($text, 3, $fileName);
    }
}