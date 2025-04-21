<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'avaiability_id' => $this->avaiability_id,
            'guest_id' => $this->guest_id,
            'date' => $this->date,
            'notes' => $this->notes,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->relationLoaded('guest')) {
            $data['guest'] = $this->guest;
        }

        if ($this->relationLoaded('avaiability') && $this->avaiability) {
            $avaiability = clone $this->avaiability;
            $data['avaiability'] = new AvailabilityResource($avaiability);
        }

        return $data;
    }
}
