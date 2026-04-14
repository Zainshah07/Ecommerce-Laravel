<?php

namespace App\Traits;

trait ApiResponseTrait{

    public function successResponse($data=null, $message = "Success", $code=200){
        return response()->json([
            'status'=>'success',
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        ], $code);
    }

      public function errorResponse($message = "Error Occured", $code=400){
        return response()->json([
            'status'=>'error',
            'code'=>$code,
            'message'=>$message,

        ], $code);
    }
}
