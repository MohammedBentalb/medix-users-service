<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception {
    protected $message = 'Invalid credentials';
    protected $code = 401;

    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}