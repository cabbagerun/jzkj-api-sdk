<?php
/**
 * 客户端入口.
 */

declare(strict_types=1);

namespace Jianzhi\Dshapi;

class Client
{
    /**
     * 配置.
     *
     * @var array
     */
    protected $config = [];

    /**
     * 域名.
     *
     * @var array
     */
    protected $domain = [
        'dev'  => 'https://api-dsh-dev.jianzhiweike.net/',
        'test' => 'https://api-dsh-test.jianzhiweike.net/',
        // 'pre'  => 'https://api-dsh-pre.jianzhiweike.net/',
        'prod' => 'https://api-dsh.jianzhiweike.net/',
    ];

    /**
     * Client constructor.
     *
     * @param $encryptKey
     * @param $env
     */
    public function __construct(string $encryptKey, string $env = 'dev')
    {
        if (empty($encryptKey)) {
            throw new \InvalidArgumentException('配置参数{encryptKey}异常');
        }
        if (empty($env) || !isset($this->domain[$env])) {
            throw new \InvalidArgumentException('配置参数{env}异常');
        }
        $this->config['encrypt_key'] = $encryptKey;
        $this->config['env']         = $env;
    }

    /**
     * 请求信息.
     *
     * @param $api 接口路由
     * @param $method 请求方式，GET、POST
     * @param $params 请求参数
     * @param $timeout 超时
     *
     * @return mixed
     */
    public function request(string $api, string $method = 'GET', array $params = [], int $timeout = 3)
    {
        $url = $this->domain[$this->config['env']] . $api;
        if ('POST' == strtolower($method)) {
            $params   = (new Sign($this->config))->getSign($params);
            $response = (new Http())->apiPost($url, $params, $timeout);
        } else {
            $params = (new Sign($this->config))->getSign($params, true);
            $url .= '?' . $params;
            $response = (new Http())->apiGet($url, $timeout);
        }

        return $response;
    }
}
