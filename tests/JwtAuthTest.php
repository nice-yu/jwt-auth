<?php
declare(strict_types=1);
namespace NiceYu\JwtAuth;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \NiceYu\JwtAuth\JwtAuth
 */
final class JwtAuthTest extends TestCase
{
    /**
     * @covers \NiceYu\JwtAuth\JwtAuth::generate
     * @covers \NiceYu\JwtAuth\Auth::build
     * @covers \NiceYu\JwtAuth\Auth::dateTime
     * @covers \NiceYu\JwtAuth\Auth::getExpire
     * @covers \NiceYu\JwtAuth\Auth::getId
     * @covers \NiceYu\JwtAuth\Auth::getIssued
     * @covers \NiceYu\JwtAuth\Auth::getPlatform
     * @covers \NiceYu\JwtAuth\Auth::getSecret
     * @covers \NiceYu\JwtAuth\Auth::isOutput
     * @covers \NiceYu\JwtAuth\Auth::setId
     * @covers \NiceYu\JwtAuth\Auth::setPlatform
     * @covers \NiceYu\JwtAuth\DES::__construct
     * @covers \NiceYu\JwtAuth\DES::decrypt
     * @covers \NiceYu\JwtAuth\DES::encrypt
     * @covers \NiceYu\JwtAuth\DES::pkcsPadding
     * @covers \NiceYu\JwtAuth\DES::unPkcsPadding
     * @covers \NiceYu\JwtAuth\JwtAuth::verify
     * @return void
     * @throws Exception
     */
    public function testTheJwtAuthGenerationMethod():void
    {
        $jwtAuth = new JwtAuth();
        $token  = $jwtAuth
            ->setId('1')
            ->generate();
        $keys = array_keys((array)$token);
        $this->assertEquals(["token","login_date","expire_date"],$keys);
    }

    /**
     * @covers \NiceYu\JwtAuth\Auth::setPlatform
     * @covers \NiceYu\JwtAuth\Auth::build
     * @covers \NiceYu\JwtAuth\Auth::dateTime
     * @covers \NiceYu\JwtAuth\Auth::getExpire
     * @covers \NiceYu\JwtAuth\Auth::getId
     * @covers \NiceYu\JwtAuth\Auth::getIssued
     * @covers \NiceYu\JwtAuth\Auth::getPlatform
     * @covers \NiceYu\JwtAuth\Auth::getSecret
     * @covers \NiceYu\JwtAuth\Auth::isOutput
     * @covers \NiceYu\JwtAuth\Auth::setExpire
     * @covers \NiceYu\JwtAuth\Auth::setId
     * @covers \NiceYu\JwtAuth\DES::__construct
     * @covers \NiceYu\JwtAuth\DES::decrypt
     * @covers \NiceYu\JwtAuth\DES::encrypt
     * @covers \NiceYu\JwtAuth\DES::pkcsPadding
     * @covers \NiceYu\JwtAuth\DES::unPkcsPadding
     * @covers \NiceYu\JwtAuth\JwtAuth::generate
     * @covers \NiceYu\JwtAuth\JwtAuth::verify
     * @return void
     * @throws Exception
     */
    public function testTheJwtAuthAuthenticationMethod():void
    {
        $jwtAuth = new JwtAuth();
        $token  = $jwtAuth
            ->setId('1')
            ->setPlatform(PlatformEnum::WEB()->value)
            ->generate();

        $verify = $jwtAuth->verify($token->token);
        $this->assertEquals('1',$verify->id);
        $this->assertEquals(PlatformEnum::WEB()->value,$verify->platform);
    }

    /**
     * @covers \NiceYu\JwtAuth\Auth::setExpire
     * @covers \NiceYu\JwtAuth\DES::decrypt
     * @covers \NiceYu\JwtAuth\DES::unPkcsPadding
     * @covers \NiceYu\JwtAuth\JwtAuth::verify
     * @covers \NiceYu\JwtAuth\JwtAuth::generate
     * @covers \NiceYu\JwtAuth\Auth::build
     * @covers \NiceYu\JwtAuth\Auth::dateTime
     * @covers \NiceYu\JwtAuth\Auth::getExpire
     * @covers \NiceYu\JwtAuth\Auth::getId
     * @covers \NiceYu\JwtAuth\Auth::getIssued
     * @covers \NiceYu\JwtAuth\Auth::getPlatform
     * @covers \NiceYu\JwtAuth\Auth::getSecret
     * @covers \NiceYu\JwtAuth\Auth::isOutput
     * @covers \NiceYu\JwtAuth\Auth::setId
     * @covers \NiceYu\JwtAuth\DES::__construct
     * @covers \NiceYu\JwtAuth\DES::encrypt
     * @covers \NiceYu\JwtAuth\DES::pkcsPadding
     * @return void
     * @throws Exception
     */
    public function testParseExpirationMethod():void
    {
        $jwtAuth = new JwtAuth();
        $token  = $jwtAuth
            ->setId('1')
            ->setExpire('-1 day')
            ->generate();

        $this->assertEquals(null,$jwtAuth->verify($token->token));
    }

    /**
     * 测试 jwt-auth 设置参数
     * @covers \NiceYu\JwtAuth\Auth::getSecret
     * @covers \NiceYu\JwtAuth\Auth::build
     * @covers \NiceYu\JwtAuth\Auth::dateTime
     * @covers \NiceYu\JwtAuth\Auth::getExpire
     * @covers \NiceYu\JwtAuth\Auth::getId
     * @covers \NiceYu\JwtAuth\Auth::getIssued
     * @covers \NiceYu\JwtAuth\Auth::getPlatform
     * @covers \NiceYu\JwtAuth\Auth::isOutput
     * @covers \NiceYu\JwtAuth\Auth::setDateTimeZone
     * @covers \NiceYu\JwtAuth\Auth::setExpire
     * @covers \NiceYu\JwtAuth\Auth::setId
     * @covers \NiceYu\JwtAuth\Auth::setIssued
     * @covers \NiceYu\JwtAuth\Auth::setOutput
     * @covers \NiceYu\JwtAuth\Auth::setPlatform
     * @covers \NiceYu\JwtAuth\Auth::setSecret
     * @covers \NiceYu\JwtAuth\DES::__construct
     * @covers \NiceYu\JwtAuth\DES::decrypt
     * @covers \NiceYu\JwtAuth\DES::encrypt
     * @covers \NiceYu\JwtAuth\DES::pkcsPadding
     * @covers \NiceYu\JwtAuth\DES::unPkcsPadding
     * @covers \NiceYu\JwtAuth\JwtAuth::generate
     * @covers \NiceYu\JwtAuth\JwtAuth::verify
     * @return void
     * @throws Exception
     */
    public function testTheJwtAuthSettingParameters():void
    {

        $jwtAuth = new JwtAuth();
        $token  = $jwtAuth
            ->setId('2')
            ->setOutput(true)
            ->setIssued('+1 day')
            ->setExpire('+1 day')
            ->setSecret('secret')
            ->setPlatform(PlatformEnum::WECHAT_PUBLIC_ACCOUNT()->value)
            ->setDateTimeZone('Asia/Shanghai')
            ->generate();

        $verify = $jwtAuth->verify($token->token);
        $this->assertEquals('2',$verify->id);
        $this->assertEquals(PlatformEnum::WECHAT_PUBLIC_ACCOUNT()->value,$verify->platform);
    }
}