<?php
/**
 * 签名类.
 */

declare(strict_types=1);

namespace Jianzhi\Dshapi;

class Sign
{
    /**
     * 签名key.
     *
     * @var mixed|string
     */
    public $encryptKey = '';

    public function __construct(array $config)
    {
        if (!isset($config['encrypt_key']) || empty($config['encrypt_key'])) {
            throw new \InvalidArgumentException('配置参数{encrypt_key}异常');
        }
        $this->encryptKey = $config['encrypt_key'];
    }

    /**
     * 获取签名.
     *
     * @param $data
     * @param $toUrlParam
     *
     * @return array|string
     */
    public function getSign(array $data, bool $toUrlParam = false)
    {
        $data['timestamp'] = time();
        $data['sign']      = $this->makeSign($data);
        if ($toUrlParam) {
            $data = http_build_query($data);
        }

        return $data;
    }

    /**
     * 生成签名.
     *
     * @param $data
     *
     * @return string
     */
    public function makeSign(array $data)
    {
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = $this->toUrlParams($data);
        //签名步骤二：在string后加入key
        $string = $string . '&key=' . $this->encryptKey;
        //签名步骤三：MD5加密
        $sign = md5($string);

        return $sign;
    }

    /**
     * 格式化参数格式化成url参数.
     *
     * @param $data
     *
     * @return string
     */
    public function toUrlParams(array $data)
    {
        $buff = '';
        foreach ($data as $k => $v) {
            if ('sign' != $k && !is_array($v)) {
                $buff .= $k . '=' . $v . '&';
            }
        }
        $buff = trim($buff, '&');

        return $buff;
    }
}
