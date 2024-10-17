<?php

namespace App\Enum;

enum FuelTypeEnum: string
{
    case PETROL = 'essence';
    case DIESEL = 'diesel';
    case ELECTRIC = 'electrique';
    case HYBRID = 'hybride';
}