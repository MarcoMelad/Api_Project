<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;

trait ApiresponseTrait
{
    public function apiResponse($data=null,$message=null,$status=null)
    {
        $array = [
            'data'=>$data,
            'message'=>$message,
            'status'=>$status,
        ];

        return response($array,$status);
    }

    protected function validateRequest($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        return null;
    }

    public function notFound($item , $message = 'Not Found')
    {
        if (!$item){
            return $this->apiResponse(null, $message, 400);
        }
    }
}
