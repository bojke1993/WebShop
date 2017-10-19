<?php

class AccessDeniedException extends Exception
{
    protected $message;

    /**
     * NotLoggedException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
