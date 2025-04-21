<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Service\BookingService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BookingLinkResource;

class BookingController extends Controller
{
    private $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
    public function create(BookingRequest $request)
    {
        try {
            $data = $this->bookingService->create($request);
            return sendResponse(
                'Booking link created successfully',
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
    public function getBookingLink($slug)
    {
        try {
            $data = $this->bookingService->getBookingLink($slug);
            if (!$data) {
                return sendError(
                    'Booking link not found',
                    [],
                    Response::HTTP_NOT_FOUND
                );
            }
            return sendResponse(
                'Booking link retrieved successfully',
                new BookingLinkResource($data),
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
