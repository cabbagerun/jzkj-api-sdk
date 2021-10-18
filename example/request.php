<?php
/**
 * @example example
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Jianzhi\Dshapi\Client;

$client = new Client('71srx3YW31fqC8Oa', 'dev');
$api    = 'dsh/User/list';
$params = [
    'user_id' => 1,
];
$result = $client->request($api, 'GET', $params, 3);
var_dump($result);
