<?php

namespace InvoiceOpenApi\Protocol;

use CoreOpenApi\Protocol\CoreClient;
use Exception;

/**
 * Class InvoiceClient
 */
class InvoiceClient extends CoreClient
{
    const  TOKEN_EXPIRED = 100002;//token过期
    const TOKEN_ERROR = 44;//TOKEN错误

    /**
     * @param $resp
     *
     * @return mixed
     */
    public function onResponse($resp)
    {
        try
        {
            $respObject = json_decode($resp, true);
            if ($respObject === null)
            {
                return [
                    'errorCode' => '-1000',
                    'errMsg'    => '服务器繁忙',
                    'data'      => $resp,
                ];
            }
            if (isset($respObject['response']) && $respObject['response'])
            {
                return [
                    'code' => '0000',
                    'data' => $respObject['response'],
                ];
            }
            else if (isset($respObject['errorResponse']) && $respObject['errorResponse'])
            { //报错
                return [
                    'errorCode' => '-1001',
                    'errMsg'    => '接口调用失败',
                    'data'      => $respObject['errorResponse'],
                ];
            }
            else
            {
                return [
                    'errorCode' => '-1002',
                    'errMsg'    => 'unknown',
                    'data'      => $respObject,
                ];
            }
        } catch (Exception $e)
        {
            return [
                'errorCode' => '-1003',
                'errMsg'    => $e->getMessage(),
                'data'      => get_object_vars($e),
            ];
        }
    }

    /**
     * 获得加密过的密码
     * @return string
     */
    public function getPassword()
    {
        $passwd = $this->config->getParamByKey('password');
        $salt   = $this->config->getParamByKey('salt');

        return sha1(md5($passwd . $salt));
    }

    /**
     * 获取token
     */
    public function getToken($params)
    {
        $method        = 'baiwang.oauth.token';
        $client_id     = $this->appKey;
        $client_secret = $this->appSecret;
        $username      = $this->config->getParamByKey('username');
        $password      = $this->getPassword();
        $version       = $this->config->getParamByKey('version');
        $timestamp     = time() * 1000;
        $url           = $this->config->getRequestUrl();
        $data          = "timestamp={$timestamp}&password={$password}&method={$method}&grant_type=password&client_secret={$client_secret}&version={$version}&client_id={$client_id}&username={$username}";


        $res = $this->doRequest($url, $data);

        $res   = json_decode($res, true);
        $token = $res['response']['access_token'];

        return ['token' => $token, 'response' => $res];
        //return $token;
    }

    /**
     * 刷新token
     */
    public function refreshToken($params)
    {
        return $this->getToken($params);
    }


    /**
     * 返回签名
     *
     * @param array  $params 公共参数
     * @param string $body   业务参数
     *
     * @return string
     */
    public function sign($params, $body)
    {
        $stringToBeSigned = $this->appSecret;
        $stringToBeSigned .= $this->getParamStrFromMap($params);
        if ($body)
        {
            $stringToBeSigned .= $body;
        }
        $stringToBeSigned .= $this->appSecret;

        return strtoupper(md5($stringToBeSigned));
    }

    /**
     * 拼接公共参数
     *
     * @param $params
     *
     * @return string
     */

    public function getParamStrFromMap($params)
    {
        unset($params['sign']);//先排除sign
        ksort($params);
        $stringToBeSigned = "";
        foreach ($params as $k => $v)
        {
            $stringToBeSigned .= "$k$v";
        }

        return $stringToBeSigned;
    }

    /**
     * @Overrides
     *
     * @param  string $method
     *
     * @param null    $params
     *
     * @return string
     */
    public function getRequestUri($method, $params = null)
    {
        $timestamp    = time();
        $type         = 'sync';
        $format       = 'json';
        $commonParams = array(
            'method'    => $method,
            'appKey'    => $this->appKey,
            'token'     => $this->token,
            'timestamp' => $timestamp,
            'version'   => $this->config->getParamByKey('version'),
            'format'    => $format,
            'type'      => $type,
        );

        $body = empty($params) ? '' : $params;
        $sign = $this->sign($commonParams, $body);
        $url  = $this->config->getParamByKey('requestUrl');

        $return = sprintf('%s?method=%s&version=%s&appKey=%s&format=%s&timestamp=%s&token=%s&type=%s&sign=%s', $url,
            $method, $this->config->getParamByKey('version'), $this->appKey, $format, $timestamp, $this->token, $type,
            $sign);

        return $return;
    }

    /**
     * 是否为token过期
     *
     * @param $resp
     *
     * @return bool
     */
    public function isTokenExpired($resp)
    {
        $code = isset($resp['data']['code']) ? $resp['data']['code'] : 0;
        if ($code == self::TOKEN_EXPIRED || $code == self::TOKEN_ERROR)
        {//token过期
            return true;
        }

        return false;
    }

    /**
     * 构建请求数据
     */
    public function buildRequestParams($body)
    {
        return json_encode($body);
    }
}