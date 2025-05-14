<?php

namespace App\Exceptions;
use Exception;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ImportErrorException extends Exception
{

    /**
     * The recommended response to send to the client.
     *
     * @var \Symfony\Component\HttpFoundation\Response|null
     */
    public $errorData;

    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @param  string  $errorBag
     * @return void
     */
    public function __construct($errorData = [])
    {
        parent::__construct('存在有问题的数据');
        $this->errorData = $errorData;

    }
    /**
     * Render the exception into an HTTP response.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getErrors()
    {
        return $this->errorData;
    }
}
