<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvaiabilityRequest;
use App\Http\Resources\AvailabilityResource;
use App\Service\AvailabiltyService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AvailabilityController extends Controller
{
    private $availabiltyService;
    /**
     * AvailabilityController constructor.
     *
     * @param AvailabiltyService $availabiltyService
     */
    public function __construct(AvailabiltyService $availabiltyService)
    {
        $this->availabiltyService = $availabiltyService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(AvaiabilityRequest $request)
    {
        try {
            $availability = $this->availabiltyService->create($request);
            return sendResponse(
                'Availability created successfully',
                $availability,
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
    /**
     * @param $host_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function hostAvailavility($host_id)
    {
        $availability = $this->availabiltyService->hostAvailavility($host_id);
        return sendResponse(
            'Availability fetched successfully',
            AvailabilityResource::collection($availability),
            Response::HTTP_OK
        );
    }
}
