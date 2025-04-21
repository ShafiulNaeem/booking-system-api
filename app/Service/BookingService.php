<?php

namespace App\Service;

use App\Models\BookingLink;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class BookingService
{
    public function create(FormRequest $request)
    {
        $data = $request->validated();
        $data['host_id'] = auth()->guard('api')->id();
        $data['slug'] = generateSlug();
        $data['status'] = $data['status'] ?? 'active';
        return BookingLink::create($data);
    }

    public function getBookingLink($slug)
    {
        $data = BookingLink::with([
            'host.avaiabilities' => function ($query) {
                $query->whereDoesntHave('appointments', function ($query) {
                    $query->where('status', '!=', 'cancelled');
                });
            },
        ])->where('slug', $slug)->first();
        return $data;
    }
}
