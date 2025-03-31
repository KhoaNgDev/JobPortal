<?php 


namespace App\Console\Commands;

class CreateJobLocationCommand{
    public string $image;
    public int $country_id;
    public ?string $status;

    public function __construct(string $imagePath, int $country_id, ?string $status){
        $this->image = $imagePath;
        $this->country_id = $country_id;
        $this->status = $status;
    }
}