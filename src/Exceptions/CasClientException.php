<?php


namespace Zbanx\CasClient\Exceptions;


use Throwable;

class CasClientException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}