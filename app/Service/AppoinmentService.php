<?php

namespace App\Service;

use App\Models\Appoinment;
use App\Models\Avaiability;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AppoinmentService
{
    public function create(FormRequest $request)
    {
        $data = $request->validated();
        $data['guest_id'] = auth()->guard('api')->id();
        $result = Appoinment::create($data);
        $result->load(['avaiability.host', 'guest']);
        return $result;
    }
    public function updateStatus(FormRequest $request)
    {
        $data = $request->validated();
        $appoinment = Appoinment::find($data['appointment_id']);
        $appoinment->status = $data['status'];
        $appoinment->save();
        return $appoinment;
    }
    public function list($params)
    {
        $params['host_id'] = auth()->guard('api')->id();
        $data = Appoinment::with(['avaiability', 'guest']);
        $data = $this->filter($data, $params);
        $data = $data->orderBy('id', 'desc')->paginate(10);
        return $data;
    }
    private function filter($data, $params)
    {
        if (array_key_exists('search', $params)) {
            if (!empty($params['search'])) {
                $data = $data->where(function ($query) use ($params) {
                    $query->where('date', 'like', '%' . $params['search'] . '%')
                        ->orWhereHas('avaiability.host', function ($q) use ($params) {
                            $q->where('name', 'like', '%' . $params['search'] . '%')
                                ->orWhere('email', 'like', '%' . $params['search'] . '%');
                        })
                        ->orWhereHas('guest', function ($q) use ($params) {
                            $q->where('name', 'like', '%' . $params['search'] . '%')
                                ->orWhere('email', 'like', '%' . $params['search'] . '%');
                        });
                });
            }
        }
        if (array_key_exists('status', $params)) {
            if (!empty($params['status'])) {
                $data = $data->where('status', $params['status']);
            }
        }
        if (array_key_exists('date_from', $params)) {
            if (!empty($queparamsry['date_from'])) {
                $data = $data->whereDate('date', '>=', $params['date_from']);
            }
        }

        if (array_key_exists('date_to', $params)) {
            if (!empty($params['date_to'])) {
                $data = $data->whereDate('date', '<=', $params['date_from']);
            }
        }
        if (array_key_exists('host_id', $params)) {
            if (!empty($params['host_id'])) {
                $data = $data->whereHas('avaiability', function ($query) use ($params) {
                    $query->where('host_id', $params['host_id']);
                });
            }
        }
        if (array_key_exists('guest_id', $params)) {
            if (!empty($params['guest_id'])) {
                $data = $data->where('guest_id', $params['guest_id']);
            }
        }
        return $data;
    }
}
