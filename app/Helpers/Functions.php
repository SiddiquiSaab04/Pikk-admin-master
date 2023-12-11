<?php

use App\Services\CoreService;

function sendResponse($is_api_request = true, $view = null, $data = null, $message = null, $http_status_code = 200)
{
    if ($is_api_request == false && isset($view)) {
        $data['data'] = $data ? $data : null;
        return view($view, $data);
    } else {
        $response = [
            'status'    => TRUE,
            'message'   => $message,
            'data'      => $data,
        ];
        return response()->json($response, $http_status_code);
    }
}

function sendError($is_api_request = true, $view = null, $error = null, $message = null, $http_status_code = 200)
{
    if ($is_api_request == false && isset($error)) {
        return redirect()->back()
            ->withErrors($error)
            ->withInput();
    } else {
        if (is_string($error)) {
            $validator = $error;
        } elseif (is_array($error->errors()->all())) {
            $error_array = $error->errors()->all();
            $validator = $error_array[0];
        } else {
            $validator = 'Something went Wrong!';
        }

        $response = [
            'status' => FALSE,
            'message' => $validator,
            'data' => null,
            'error' => isset($message) ? $message : 'An error occurred!',
        ];

        return response()->json($response, $http_status_code);
    }
}

/**
 * returns an instance of core service
 */
function core() : CoreService
{
    return app()->make( CoreService::class );
}
