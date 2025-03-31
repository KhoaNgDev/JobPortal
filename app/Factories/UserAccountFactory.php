<?php

namespace App\Factories;

use App\Contracts\UserAccountInterface;
use App\Services\AdminAccount;
use App\Services\CustomerAccount;

class UserAccountFactory
{
    public static function create(string $type): UserAccountInterface
    {
        return match ($type) {
            'admin' => new AdminAccount(),
            'customer' => new CustomerAccount(),
            default => throw new \Exception("Invalid account type"),
        };
    }
}
