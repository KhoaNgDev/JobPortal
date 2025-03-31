<?php

namespace App\Observers;

use App\Models\City;
use Illuminate\Support\Facades\Log;

class CityObserver
{
    /**
     * Lắng nghe sự kiện khi một City được tạo.
     */
    public function created(City $city)
    {
        Log::info("City created: " . $city->name);
    }

    /**
     * Lắng nghe sự kiện khi một City được cập nhật.
     */
    public function updated(City $city)
    {
        Log::info("City updated: " . $city->name);
    }

    /**
     * Lắng nghe sự kiện khi một City bị xóa.
     */
    public function deleted(City $city)
    {
        Log::warning("City deleted: " . $city->name);
    }
}
