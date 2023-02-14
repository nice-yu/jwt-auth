<?php
declare(strict_types=1);

namespace NiceYu\JwtAuth;

use DateTime;

class AuthDto
{
    public string $id;
    public DateTime $issued;
    public DateTime $expire;

    public string $platform;
}