<?php

namespace App\Enum;

enum UserTypeEnum: string
{
    case PERSONAL = 'particulier';
    case COMPANY = 'entreprise';
}
