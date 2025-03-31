<?php

namespace App\Services;

use App\Contracts\UserAccountInterface;

class CustomerAccount implements UserAccountInterface
{
    public function getRole(): string
    {
        return "Customer";
    }
}
