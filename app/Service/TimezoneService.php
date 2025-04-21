<?php

namespace App\Service;

use App\Models\BookingLink;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;

class TimezoneService
{
    protected $timezone;
    protected $locations;

    public function __construct()
    {
        $this->detectLocation();
    }
    public function detectLocation()
    {
        $ip = request()->ip();
        $location = Location::get($ip);
        $this->locations = $location;
        $this->timezone = $location?->timezone ?? config('app.timezone');
    }

    public function getLocation()
    {
        return $this->locations;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }
}
