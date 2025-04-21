<?php

namespace App\Http\Resources;

use App\Service\TimezoneService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Ramsey\Uuid\Type\Time;

class AvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userTimezone = app(TimezoneService::class)->getTimezone();
        // dd($userTimezone, $this);

        // Convert start and end time from host's availability time zone to user's time zone
        $start = Carbon::createFromFormat('H:i:s', $this->start_time, $this->time_zone)
            ->setTimezone($userTimezone);
        $end = Carbon::createFromFormat('H:i:s', $this->end_time, $this->time_zone)
            ->setTimezone($userTimezone);

        $data = [
            'id' => $this->id,
            'weekday' => $this->weekday,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'time_zone' => $this->time_zone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_timezone_wise_data' =>
            [
                'start_time' => $start->format('H:i:s'),
                'end_time' => $end->format('H:i:s'),
                'time_zone' => $userTimezone
            ]
        ];

        if ($this->relationLoaded('host')) {
            $host = clone $this->host;
            $host->setRelation('avaiabilities', collect());
            $data['host'] = new HostResource($host);
        }
        if ($this->relationLoaded('appointments')) {
            $appointments = clone $this->appointments;
            $appointments->setRelation('guest', collect());
            $appointments->setRelation('avaiability', collect());
            $data['appointments'] = AppointmentResource::collection($appointments);
        }

        return $data;
    }
}
