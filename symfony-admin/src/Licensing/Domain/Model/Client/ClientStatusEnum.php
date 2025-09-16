<?php

namespace App\Licensing\Domain\Model\Client;

enum ClientStatusEnum: string
{
    case ONBOARDING = 'onboarding';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';
}
