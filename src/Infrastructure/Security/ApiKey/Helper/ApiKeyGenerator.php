<?php

namespace App\Infrastructure\Security\ApiKey\Helper;

class ApiKeyGenerator
{
    public static function generate(): string
    {
        return bin2hex(random_bytes(32));
    }
}
