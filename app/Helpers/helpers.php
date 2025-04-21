<?php

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

if (!function_exists('sendResponse')) {
    /**
     * @param $message
     * @param $result
     * @param int $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function sendResponse($message, $result, int $code = 200)
    {
        $response = [
            'code' => $code,
            'success' => true,
            'message' => $message,
            'data' => $result,
            'errors' => []
        ];

        return response($response, $code);
    }
}


if (!function_exists('sendError')) {
    /**
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function sendError($message, array $error = [], int $code = 404)
    {
        $response = [
            'code' => $code,
            'success' => false,
            'message' => $message,
            'data' => [],
            'errors' => $error,
        ];

        return response($response, $code);
    }
}

if (!function_exists('sendInternalServerError')) {

    /**
     * @param Exception $exception
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function sendInternalServerError(\Exception $exception)
    {
        $response['errors'] = ['error' => 'Internal Server Error'];
        if (env('APP_ENV') != 'local') {
            $response['errors'] = [
                'message' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'trace' => $exception->getTrace(),
            ];
        }

        // $response = [
        //     'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
        //     'success' => false,
        //     'message' => 'Something went wrong.',
        //     'data' => []
        // ];
        $response['errors'] = [
            'message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            // 'file' => $exception->getFile(),
            // 'trace' => $exception->getTrace(),
        ];
        return response($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
if (!function_exists('perPage')) {
    /**
     * @param $params
     * @return int|mixed $paginate,
     */
    function perPage($params)
    {
        $paginate = 10;

        if (array_key_exists('per_page', $params)) {
            if ($params['per_page']) {
                $paginate = $params['per_page'];
            }
        }

        return $paginate;
    }
}
if (!function_exists('generateSlug')) {
    /**
     * @param $string
     * @return string
     */
    function generateSlug()
    {
        $string = Str::random(10) . '-' . time();
        return strtolower($string);
    }
}
