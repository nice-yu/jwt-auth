<?php
declare(strict_types=1);

namespace NiceYu\JwtAuth;

use DateTime;

class JwtAuthDto
{
    public string $token;

    public DateTime $login_date;

    public DateTime $expire_date;
}