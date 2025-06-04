<?php


namespace App\Enums;

enum RolesEnum: string
{


    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::EMPLOYEE => 'employee',
        };
    }
}
