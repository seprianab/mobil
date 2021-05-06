<?php

if (!function_exists('successDataResponse')){
    function successDataResponse($data){
        return response()->json($data, 200);
    }
}

if (!function_exists('successResponse')){
    function successResponse($message = null){
        $response = [];
        if($message != null) $response['message'] = $message;
        return response()->json($response, 200);
    }
}

if (!function_exists('errorResponse')){
    function errorResponse($code, $message, $status_code = 400, $errors = null){
        $response = [
            'code' => $code,
            'message' => $message
        ];
        if($errors != null) $response['errors'] = $errors;

        return response()->json($response, $status_code);
    }
}

if (!function_exists('errorInputResponse')){
    function errorInputResponse($validator){
        return response()->json([
            'code' => 'input',
            'errors' => $validator->errors()->messages()
        ], 400);
    }
}