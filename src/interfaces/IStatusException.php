<?php

interface IStatusException
{
    public function getStatus(): ResponseEnum;
}
