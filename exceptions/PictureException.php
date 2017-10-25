<?php

class PictureException extends Exception
{
    protected $message;

    /**
     * PictureException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}