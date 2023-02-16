> [简体中文](README.zh-CN.md) | [English](README.md)

### Login token implementation
Generate/parse generic login tokens using the jwt-auth scheme

#### Install
```
composer require nice-yu/jwt-auth
```

#### Unit Test Information
- Unit tests with 100% coverage

```
Jwt Auth (NiceYu\JwtAuth\JwtAuth)
 ✔ The jwt auth generation method [2.75 ms]
 ✔ The jwt auth authentication method [4.58 ms]
 ✔ Parse expiration method [4.18 ms]
 ✔ The jwt auth setting parameters [107.75 ms]
```

#### configuration information
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

#### Configuration must be passed
- `setId()` The necessary parameter identification for generating `token`
#### Unnecessary parameter configuration
- `setIssued()` Set the issue time, the default value is: ''
- `setExpire()` Set the expiration time, the default value is: '+1 day'
- `setOutput()` Set the encryption method, the default value is: false (true=OUTPUT_BASE64, false=OUTPUT_HEX)
- `setSecret()` Set the key information, the default value is: '8a8b57b12684504f511e85ad5073d1b2b430d143a'
- `setPlatform()` Set the platform ID, the default value is: 'web'
- `setDateTimeZone()` Set the current time zone, the default is: 'Asia/Shanghai'

#### generate `token`
```php
$jwtAuth = new JwtAuth();
$token  = $jwtAuth->setId('1')->generate()
```
`$token` information for `JwtAuthDto` class
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

#### analyze `token`
```php
$jwtAuth = new JwtAuth();
$token  = $jwtAuth->setId('1')->generate();
$userInfo = $jwtAuth->verify($token->token);
```
`$userInfo` information for `AuthDto` class
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
Returns `null` if `$token->token` has exceeded the expiration time `$token->expire`

#### requires attention
When `$token->token` is tampered with without authorization, a fatal error will occur, remember `try` to capture