<?php

namespace App\Services;

use App\Contracts\UserAccountInterface;

class AdminAccount implements UserAccountInterface
{
    public function getRole(): string
    {
        return "Admin";
    }
}
