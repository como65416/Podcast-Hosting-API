<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

abstract class AbstractHttpException extends Exception
{
    /**
     * @var int error response status code
     */
    protected $statusCode = 500;

    /**
     * @var array detail error information
     */
    protected $errors = [];

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return \Illuminate\Http\Response response content
     */
    public function toResponse()
    {
        $body = [
            'message' => $this->getMessage(),
        ];

        if (!empty($this->errors)) {
            $body['errors'] = $this->errors;
        }

        return new JsonResponse($body, $this->statusCode);
    }
}
