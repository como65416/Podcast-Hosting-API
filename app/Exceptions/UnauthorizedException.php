<?php

namespace App\Exceptions;

use App\Exceptions\AbstractHttpException;

class UnauthorizedException extends AbstractHttpException
{
    /**
     * {@inheritDoc}
     */
    protected $statusCode = 401;
}
