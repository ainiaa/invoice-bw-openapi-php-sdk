<?php

namespace InvoiceOpenApi\Protocol;

use CoreOpenApi\Protocol\CoreClient;

//use CoreOpenApi\Api\RequestService;
//use CoreOpenApi\Config\Config;
//use stdClass;
use Exception;

/**
 * Class InvoiceClient
 */
class InvoiceClient extends CoreClient
{
    /**
     * @param $resp
     *
     * @return mixed
     * @throws Exception
     */
    public function onResponse($resp)
    {
        try
        {
            $respObject = json_decode($resp, true);
            if ($respObject === null)
            {
                throw new Exception('服务器繁忙');
            }
            if ($respObject['response'])
            {
                return $respObject['response'];
            }
            else if ($respObject['errorResponse'])
            { //报错
                return $respObject['response'];
            }
        } catch (Exception $e)
        {
            throw $e;
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
    public function getToken()
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

        return $token;
    }

    /**
     * @todo 还没有实现
     * 刷新token
     */
    public function refreshToken()
    {

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
        ksort($params);

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
        $timestamp    = 1530188192;//time();
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

        return sprintf('%s?method=%s&version=%s&appKey=%s&format=%s&timestamp=%s&token=%s&type=%s&sign=%s', $url,
                $method, $this->config->getParamByKey('version'), $this->appKey, $format, $timestamp, $this->token,
                $type, $sign);
    }

    /**
     * @TODO 这个需要根据不同的api 实现不同的构建方法
     * 构建请求数据
     */
    public function buildRequestParams($body)
    {
        return json_encode($body);
    }
}