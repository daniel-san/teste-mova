<?php

namespace App\Contracts;

interface MessageStrategyContract
{
    public function getMessage(): string;
}