<?php
declare(strict_types=1);

namespace NiceYu\JwtAuth;

use DateTime;
use DateTimeZone;
use Exception;

class Auth
{
    /**
     * zh: 用户 ID
     * en: user Id
     * @var string
     */
    private string $id = '';

    /**
     * zh: 颁发时间 - 时间戳 (reduce)
     * en: Issue time - timestamp (+ day)
     * @var string
     */
    private string $issued = "";

    /**
     * zh: 过期时间 - 时间戳 (addition)
     * en: Expire time - timestamp (+ day)
     * @var string
     */
    private string $expire = "+1 day";

    /**
     * zh: 设置时区
     * en: set time zone
     */
    private string $dateTimeZone = 'Asia/Shanghai';

    /**
     * zh: 平台标识
     * en: Platform ID
     * @var string
     */
    private string $platform = 'web';

    /**
     * zh: 密钥
     * en: encryption key
     * @var string
     */
    private string $secret = '8a8b57b12684504f511e85ad5073d1b2b430d143a';

    /**
     * zh: 加密方式 (true=OUTPUT_BASE64, false=OUTPUT_HEX)
     * en: Encryption
     * @var bool
     */
    private bool $output = false;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssued(): string
    {
        return $this->issued;
    }

    /**
     * @param string $issued
     * @return $this
     */
    public function setIssued(string $issued): self
    {
        $this->issued = $issued;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpire(): string
    {
        return $this->expire;
    }

    /**
     * @param string $expire
     * @return $this
     */
    public function setExpire(string $expire): self
    {
        $this->expire = $expire;
        return $this;
    }

    /**
     * @param string $dateTimeZone
     * @return $this
     */
    public function setDateTimeZone(string $dateTimeZone): self
    {
        $this->dateTimeZone = $dateTimeZone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     * @return $this
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOutput(): bool
    {
        return $this->output;
    }

    /**
     * @param bool $output
     * @return $this
     */
    public function setOutput(bool $output): self
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return DES
     */
    protected function build(): DES
    {
        $output = $this->isOutput();
        if ($output){
            $output = DES::OUTPUT_BASE64;
        }else{
            $output = DES::OUTPUT_HEX;
        }
        return new DES($this->getSecret(), 'DES-ECB', $output);
    }

    /**
     * zh: 设置时间信息
     * en: Set time information
     * @param string $day
     * @return DateTime
     */
    protected function dateTime(string $day = ''): DateTime
    {
        $dateTime = new DateTime($day);
        $timeZone = new DateTimeZone($this->dateTimeZone);
        return $dateTime->setTimezone($timeZone);
    }

}