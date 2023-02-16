> [简体中文](README.zh-CN.md) | [English](README.md)

### 登录令牌实现
使用 jwt-auth 方案,生成/解析通用的登录令牌

#### 安装
```
composer require nice-yu/jwt-auth
```

#### 单元测试信息
- 覆盖率 100% 的单元测试

```
Jwt Auth (NiceYu\JwtAuth\JwtAuth)
 ✔ The jwt auth generation method [2.75 ms]
 ✔ The jwt auth authentication method [4.58 ms]
 ✔ Parse expiration method [4.18 ms]
 ✔ The jwt auth setting parameters [107.75 ms]
```

#### 配置信息
```php
$jwtAuth = new JwtAuth();
$token  = $jwtAuth
    ->setId('1')
    ->setIssued('+1 day')
    ->setExpire('+1 day')
    ->setOutput(true)
    ->setSecret('secret')
    ->setPlatform('web')
    ->setDateTimeZone('Asia/Shanghai')
```

#### 必须传参配置
- `setId()` 生成 `token` 的必要参数标识
#### 非必要传参配置
- `setIssued()` 设置颁发时间, 默认值为: ''
- `setExpire()` 设置过期时间, 默认值为: '+1 day' 
- `setOutput()` 设置加密方式, 默认值为: false (true=OUTPUT_BASE64, false=OUTPUT_HEX)
- `setSecret()` 设置密钥信息, 默认值为: '8a8b57b12684504f511e85ad5073d1b2b430d143a'
- `setPlatform()` 设置平台标识, 默认值为: 'web' 
- `setDateTimeZone()` 设置当前时区, 默认值为: 'Asia/Shanghai'

#### 生成 `token`
```php
$jwtAuth = new JwtAuth();
$token  = $jwtAuth->setId('1')->generate()
```
`$token` 信息为 `JwtAuthDto` 类
```
^ NiceYu\JwtAuth\JwtAuthDto {#7 ▼
  +token: "aa20bbec19534191e59d96ae777f2caeaab149111d45c5578ec4251401a21880e7676a65a334a548ea8b4c9bfae9e009d9718f83f5744a503fd91db6994ebe4392af98ddad542f849ef7f36f720df877 ▶"
  +login_date: DateTime @1676373908 {#19 ▼
    date: 2023-02-14 19:25:08.782022 Asia/Shanghai (+08:00)
  }
  +expire_date: DateTime @1676460308 {#46 ▼
    date: 2023-02-15 19:25:08.782118 Asia/Shanghai (+08:00)
  }
}
```

#### 解析 `token`
```php
$jwtAuth = new JwtAuth();
$token  = $jwtAuth->setId('1')->generate();
$userInfo = $jwtAuth->verify($token->token);
```
`$userInfo` 信息为 `AuthDto` 类
```
^ NiceYu\JwtAuth\AuthDto {#85 ▼
  +id: "1"
  +issued: DateTime @1676374087 {#92 ▼
    date: 2023-02-14 19:28:07.0 +08:00
  }
  +expire: DateTime @1676460487 {#93 ▼
    date: 2023-02-15 19:28:07.0 +08:00
  }
  +platform: "web"
}
```
假如 `$token->token` 已经超过过期时间 `$token->expire` 则返回 `null`

#### 需要注意
当 `$token->token` 被擅自篡改时, 会出现致命错误, 记得 `try` 捕获