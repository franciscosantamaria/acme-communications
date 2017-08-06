<?php

namespace AppBundle\Model\Exception;


use Throwable;

class InvalidNumberFormat extends \Exception
{
    public function __construct($message = 'Invalid number format', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
