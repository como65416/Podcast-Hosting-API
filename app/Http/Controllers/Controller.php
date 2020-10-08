<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param  Request $request
     * @param  array   $rules   laravel validate rules
     *
     * @throws \App\Exceptions\BadRequestException if any rule is not validated
     */
    protected function validateRequest(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);

        $errors = $validator->errors();
        if ($errors->any()) {
            throw (new BadRequestException('input not validated'))->setErrors($errors->all());
        }
    }
}
