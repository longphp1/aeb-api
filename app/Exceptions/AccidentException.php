<?php

namespace App\Exceptions;

use Exception;

class AccidentException extends Exception
{
    /**
     * The recommended response to send to the client.
     *
     * @var \Symfony\Component\HttpFoundation\Response|null
     */
    protected $response;

    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  array|Arrayable  $data
     * @param  array  $replace
     */
    public function __construct($message = '请求失败', int $status = 200, $data = null, array $replace = [])
    {
        $this->response = formatRet(0, $message, $data, $status, $replace);
        $this->message = $message;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render()
    {
        return $this->getResponse();
    }

    /**
     * Get the underlying response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
