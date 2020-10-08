<?php

namespace App\Exceptions;

use App\Exceptions\AbstractHttpException;

class BadRequestException extends AbstractHttpException
{
    /**
     * {@inheritDoc}
     */
    protected $statusCode = 400;
}
