<?php

/**
 * 基于 redis + lua 的去重队列
 */
class RLuniqueQueue
{
    private $push = <<<PUSH
        local lkey = KEYS[1]
        local method = KEYS[2]
        local lkey_set = lkey .. ":uni_k_set"
        local data = ARGV[1]
        local v = redis.call("SADD", lkey_set, data)
        if v == 1 then
            return redis.call(method, lkey, data) and 1
        else
            return 0
        end
PUSH;

    private $pop = <<<POP
        local lkey = KEYS[1]
        local method = KEYS[2]
        local lkey_set = lkey .. ":uni_k_set"
        local v = redis.call(method, lkey)
        if v ~= "" then
            redis.call("SREM", lkey_set, v)
        end
        return v
POP;


    static $instance = null;
    /**
     * @var Redis
     */
    private $redis;


    private function __construct($config)
    {
        $this->redis = RedisHelper::getInstance('default', $config);
    }

    public static function getInstance($config)
    {
        if (empty(self::$instance))
        {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function rPush($key, $data)
    {
        return $this->push($key, 'RPUSH', $data);
    }

    public function lPop($key)
    {
        return $this->pop($key, 'LPOP');
    }

    public function lPush($key, $data)
    {
        return $this->push($key, 'LPUSH', $data);
    }

    public function rPop($key)
    {
        return $this->pop($key, 'RPOP');
    }

    public function lLen($key)
    {
        return $this->redis->lLen($key);
    }

    public function lRange($key, $start, $end)
    {
        return $this->redis->lRange($key, $start, $end);
    }

    private function push($key, $pushMethod, $data)
    {
        return $this->redis->evaluate($this->push, [$key, $pushMethod, $data], 2);
    }

    private function pop($key, $popMethod)
    {
        return $this->redis->evaluate($this->pop, [$key, $popMethod], 2);
    }

}