<?php

declare(strict_types=1);

namespace App\Exceptions;


class RouteNotFoundException extends \Exception
{
    /**
     * Override the message of not found
     * @var string
     */
    protected $message = '404 - Page Not Found!';
}