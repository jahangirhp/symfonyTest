<?php

namespace App\DTO;

class ValidationDTO
{
public bool $success ;
public string $message ;
    public function __construct(
        $success=false,
        $message = null
    ) {}
}
