<?php

namespace App\Api\Exception\Http;

use Exception;

abstract class AbstractHttpClientException extends Exception
{
    /**
     * @var array
     */
    protected $data;

    /**
     * UnprocessableEntityException constructor.
     * @param string $message
     * @param array $data
     * @param null $previous
     */
    public function __construct(string $message = "", array $data = [], $previous = null)
    {
        $this->data = $data;
        $defaultMessage = $this->getDefaultMessage();

        parent::__construct($message ? $defaultMessage . " | " . $message : $defaultMessage, $this->code, $previous);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    abstract protected function getDefaultMessage(): string;
}