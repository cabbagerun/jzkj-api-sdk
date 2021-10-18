# 简知API SDK

#### 介绍
简知API SDK

#### 环境要求

- php >= 7.0
- curl

#### 安装教程

```bash
#绑定域到composer.jianzhikeji.com
composer config  repo.jianzhi composer http://composer.jianzhikeji.com   

#secure-http全局属性设置为false，避免只有https的链接才能被下载
composer config secure-http false

composer require --no-dev jianzhi/jzkj-api-sdk
```

#### 测试

```bash
./vendor/bin/phpunit tests/Test
```

#### 使用说明

参考example
```bash
require_once __DIR__ . '/../vendor/autoload.php';

use Jianzhi\Dshapi\Client;

$client = new Client('71srx3YW31fqC8Oa', 'dev');
$api    = 'dsh/User/list';
$params = [
    'user_id' => 1,
];
$result = $client->request($api, 'GET', $params, 3);
var_dump($result);
```