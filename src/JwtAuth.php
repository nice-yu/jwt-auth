<?php
namespace NiceYu\JwtAuth;
use Exception;
use JMS\Serializer\SerializerBuilder;

class JwtAuth extends Auth
{
    /**
     * zh: 生成令牌
     * en: 生成令牌
     * @return JwtAuthDto
     * @throws Exception
     */
    public function generate(): JwtAuthDto
    {
        /**
         * zh: 设置 dto 信息
         * en: Set dto information
         */
        $dto = new AuthDto();
        $dto->id = $this->getId();
        $dto->issued = $this->dateTime($this->getIssued());
        $dto->expire = $this->dateTime($this->getExpire());
        $dto->platform = $this->getPlatform();

        /**
         * zh: 将内容进行加密
         * en: encrypt the content
         */
        $serializer = SerializerBuilder::create()->build();

        /**
         * zh: 返回回退内容 JwtAuthDto
         * en: Return fallback content JwtAuthDto
         */
        $jwtAuthDto = new JwtAuthDto();
        $jwtAuthDto->token = $this->build()->encrypt($serializer->serialize($dto,'json'));
        $jwtAuthDto->login_date = $this->dateTime();
        $jwtAuthDto->expire_date = $this->dateTime($this->getExpire());
        return $jwtAuthDto;
    }

    /**
     * zh: 解析令牌
     * en: parsing token
     * @param string $token
     * @return AuthDto|null
     * @throws Exception
     */
    public function verify(string $token): ?AuthDto
    {
        /**
         * zh: 将 token 解析出来
         * en: Parse the token out
         */
        $data = $this->build()->decrypt($token);

        /**
         * zh: 将信息转换成 AuthDto
         * en: Convert info into AuthDto
         * @var AuthDto $obj
         */
        $obj = SerializerBuilder::create()->build()->deserialize($data, AuthDto::class, 'json');

        /**
         * zh: 验证过期时间
         * en: Verification expiration time
         */
        if ($obj->expire->getTimestamp() < time()) {
            return null;
        }
        return $obj;
    }
}