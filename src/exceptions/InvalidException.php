<?php

class InvalidException extends InvalidArgumentException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        http_response_code(ResponseEnum::HTTP_UNPROCESSABLE_ENTITY->value);
    }
}
