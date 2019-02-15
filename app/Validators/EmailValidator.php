<?php

namespace App\Validators;

class EmailValidator
{
    public static function isValid(?string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
