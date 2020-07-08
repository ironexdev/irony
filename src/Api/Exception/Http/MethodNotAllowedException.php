<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class MethodNotAllowedException extends AbstractHttpClientException
{
    /**
     * @var array
     */
    private $allowedMethods = [];

    /**
     * @var int
     */
    protected $code = 405;

    /**
     * MethodNotAllowedException constructor.
     * @param string $message
     * @param array $data
     * @param array $allowedMethods
     * @param null $previous
     */
    public function __construct(string $message = "", array $data = [], array $allowedMethods = [], $previous = null)
    {
        $this->allowedMethods = $allowedMethods;

        parent::__construct($message, $data, $previous);
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Method Not Allowed__/x__");
    }
}