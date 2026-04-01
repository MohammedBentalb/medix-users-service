<?php

namespace App\Exceptions;

use Exception;

class InvalidPasswordException extends Exception {
    protected $message = 'Current password is incorrect';
    protected $code = 422;

    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}