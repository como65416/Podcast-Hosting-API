<?php

namespace App\Exceptions;

use App\Exceptions\AbstractHttpException;

class ForbiddenException extends AbstractHttpException
{
    /**
     * {@inheritDoc}
     */
    protected $statusCode = 403;
}
