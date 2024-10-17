<?php

namespace App\Enum;

enum TransmissionTypeEnum: string
{
    case AUTOMATIC = 'automatique';
    case MANUAL = 'manuelle';
    case SEMI_AUTOMATIC = 'semi-automatique';
}
