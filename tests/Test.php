<?php
/**
 * PHPUnit Test
 */

namespace Jianzhi\Tests;

use Jianzhi\Dshapi\Client;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    private $client;

    protected function setUp()
    {
        $encryptKey   = '71srx3YW31fqC8Oa';
        $env          = 'dev';
        $this->client = new Client($encryptKey, $env);
    }

    public function testRequestSuc()
    {
        $api    = 'dsh/User/list';
        $params = [
            'user_id' => 1,
        ];
        $result = $this->client->request($api, 'GET', $params, 3);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('msg', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertTrue((1000 == $result['code']));
        $this->assertTrue(!empty($result));
    }
}
