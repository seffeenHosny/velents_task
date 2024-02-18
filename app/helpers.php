<?php



if (!function_exists('get_file_url')) {
    function get_file_url($path)
    {
        if ($path) {
            return asset("storage/$path");
        }

        return asset("assets/media/logo.png");
    }
}

/**
 * [message return the api responses]
 * @param boolean $status [status true success false for failure]
 * @param array $data [object will be sent]
 * @param string $message [message will be sent]
 * @param integer $code [for response code]
 * @return Response
 */

if (!function_exists('message')) {
    function message($data = [], $message = '', $status = true, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'status' => $status,
            'data' => $data ?? [],
        ], $code);
    }
}

if (!function_exists('resource_collection')) {
    function resource_collection($resource): array
    {
        return json_decode($resource->response()->getContent(), true) ?? [];
    }
}


if (!function_exists('requiredIf')) {
    function requiredIf($var)
    {
        return $var ? 'required' : 'nullable';
    }
}
