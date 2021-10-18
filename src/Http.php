<?php
/**
 * http请求类.
 */

declare(strict_types=1);

namespace Jianzhi\Dshapi;

class Http
{
    /**
     * get请求
     *
     * @param $url
     * @param $timeout
     *
     * @return array
     */
    public function apiGet(string $url, int $timeout = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        curl_close($ch);

        return $this->processResp($output);
    }

    /**
     * post请求
     *
     * @param $url
     * @param $data
     * @param $timeout
     *
     * @return array
     */
    public function apiPost(string $url, array $data = [], int $timeout = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);

        return $this->processResp($output);
    }

    /**
     * 处理响应结果.
     *
     * @param $response
     *
     * @return array
     */
    public function processResp($response)
    {
        if (!is_string($response)) {
            throw new \LogicException(json_encode($response, JSON_UNESCAPED_UNICODE));
        }

        $result = @json_decode($response, true);

        if (!isset($result['code'])) {
            throw new \LogicException($response);
        }

        return [
            'code' => (int) $result['code'],
            'msg'  => (string) ($result['msg'] ?? 'response fail.'),
            'data' => (array) ($result['data'] ?? []),
        ];
    }
}
