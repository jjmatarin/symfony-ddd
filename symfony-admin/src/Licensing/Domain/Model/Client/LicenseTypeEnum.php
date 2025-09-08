<?php

namespace App\Licensing\Domain\Model\Client;

enum LicenseTypeEnum: string
{
    case BASIC = 'basic';
    case MEDIUM = 'medium';
    case PREMIUM = 'premium';
}
