<?php

namespace App\Exceptions;

use Exception;

class InvalidRefreshToken extends Exception {
    protected $message = "Invalid RefreshToken";
    protected $code = 400;

    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}