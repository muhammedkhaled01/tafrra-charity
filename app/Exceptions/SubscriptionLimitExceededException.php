<?php

namespace App\Exceptions;

use Exception;

class SubscriptionLimitExceededException extends Exception
{
    public function __construct(string $message = "You have reached your plan's limit. Please upgrade to add more beneficiaries.", int $code = 403, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
