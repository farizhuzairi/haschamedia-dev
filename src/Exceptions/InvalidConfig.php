<?php

namespace HaschaDev\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class InvalidConfig extends Exception
{
    protected bool $isRender = false;

    public function __construct(
        string $message = '',
        int $code = 0,
        bool $isRender = false
    )
    {
        $this->isRender = $isRender;
        $msg = "Configuration problem.";
        $message = !empty($message) ? "{$msg} {$message}" : $msg;
        parent::__construct($message, $code);
    }

    public function report(): bool
    {
        Log::error($this->getMessage());
        return false;
    }

    public function render(): bool
    {
        return false;
    }
}
