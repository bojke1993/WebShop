<?php

class CategoryErrorException extends Exception
{
    protected $message;

    /**
     * ProductErrorException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}