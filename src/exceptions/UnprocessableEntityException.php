<?php

class UnprocessableEntityException extends InvalidArgumentException implements IStatusException
{
    public function getStatus(): ResponseEnum
    {
        return ResponseEnum::HTTP_UNPROCESSABLE_ENTITY;
    }
}
