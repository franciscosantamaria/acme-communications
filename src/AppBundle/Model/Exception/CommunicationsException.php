<?php

namespace AppBundle\Model\Exception;


use Throwable;

class CommunicationsException extends \Exception
{
    public function __construct($message = 'There was a problem retrieving the info', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
