<?php

namespace App\Handlers;

use App\Console\Commands\CreateJobLocationCommand;
use App\Models\JobLocation;

class HandleCreateJobLocation
{
    public function handle($command)
    {
        try {

            return JobLocation::create([
                'image' => $command->image,
                'country_id' => $command->country_id,
                'status' => $command->status,
            ]);
        }catch(\Exception $e){
            throw $e;
        }
    }
}
