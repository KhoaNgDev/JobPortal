<?php

namespace App\Handlers;

use App\Console\Commands\CreateJobLocationCommand;
use App\Models\JobLocation;
use Illuminate\Support\Facades\Validator;
use League\Tactician\Middleware;

class CreateJobLocationValidator implements Middleware
{
    protected array $rules = [
        'image' => 'required|string',
        'country_id' => 'required|integer|exists:countries,id',
        'status' => 'nullable|in:active,inactive',
    ];

    public function execute($command, callable $next)
    {
        $validator = Validator::make([
            'image' => $command->image,
            'country_id' => $command->country_id,
            'status' => $command->status,
        ], $this->rules);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        return $next($command);
    }
}
