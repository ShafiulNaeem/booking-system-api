<?php

namespace App\Service;

use App\Models\Avaiability;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AvailabiltyService
{
    /**
     * @param $request
     * @return mixed
     */
    public function create(FormRequest $request)
    {
        $user_id = auth()->guard('api')->id();
        $data = $request->validated();
        $data['host_id'] = $user_id;


        // Convert to UTC
        $startUtc = Carbon::createFromFormat('H:i', $data['start_time'], $data['time_zone'])->setTimezone('UTC');
        $endUtc = Carbon::createFromFormat('H:i', $data['end_time'], $data['time_zone'])->setTimezone('UTC');

        // Check for overlapping slots for the same user on the same weekday
        $conflict = Avaiability::where('host_id', $user_id)
            ->where('weekday', $data['weekday'])
            ->get()
            ->filter(function ($existing) use ($startUtc, $endUtc) {
                $existingStart = Carbon::createFromFormat('H:i:s', $existing->start_time, $existing->time_zone)->setTimezone('UTC');
                $existingEnd = Carbon::createFromFormat('H:i:s', $existing->end_time, $existing->time_zone)->setTimezone('UTC');
                return $startUtc < $existingEnd && $endUtc > $existingStart;
            });

        if ($conflict->isNotEmpty()) {
            return sendError(
                'Time slot conflict',
                [
                    'error' => 'This time slot overlaps with an existing one for this weekday.'
                ],
                422
            );
        }
        return Avaiability::create($data);
    }
    /**
     * @param $host_id
     * @return mixed
     */
    public function hostAvailavility($host_id)
    {
        return Avaiability::where('host_id', $host_id)->get();
    }
}
