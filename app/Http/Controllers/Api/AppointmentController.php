<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\AppointmentStatusRequest;
use App\Models\User;
use App\Notifications\AppointmentBooking;
use App\Service\AppoinmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    private $apointmentService;
    public function __construct(AppoinmentService $apointmentService)
    {
        $this->apointmentService = $apointmentService;
    }

    public function create(AppointmentRequest $request)
    {
        try {
            $data = $this->apointmentService->create($request);
            $emails = [];
            $emails[] = $data->avaiability->host->email;
            $emails[] = $data->guest->email;
            $host = User::find($data->avaiability->host_id);
            $users = User::whereIn('id', [$data->avaiability->host_id, $data->guest_id])->get();

            Notification::send($users, new AppointmentBooking($data->toArray()));
            return sendResponse(
                'Appointment created successfully',
                $data,
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return sendError(
                'something went wrong',
                [
                    'error' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function updateStatus(AppointmentStatusRequest $request)
    {
        try {
            $data = $this->apointmentService->updateStatus($request);
            return sendResponse(
                'Appointment status updated successfully',
                $data,
                Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return sendError(
                'something went wrong',
                [
                    'error' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function list(Request $request)
    {
        try {
            $data = $this->apointmentService->list($request->all());
            return sendResponse(
                'Appointment list',
                $data,
                Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return sendError(
                'something went wrong',
                [
                    'error' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
