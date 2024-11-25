<?php

namespace App\Enum;

enum UserTypeEnum: string
{
    case PERSONAL = 'particulier';
    case COMPANY = 'entreprise';

    public static function getChoices(): array
    {
        return [
            'Pour vous' => self::PERSONAL,
            'Pour votre entreprise' => self::COMPANY
        ];
    }
}
