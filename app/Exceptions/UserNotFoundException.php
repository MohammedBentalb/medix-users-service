<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception {
    protected $message = 'User not found';
    protected $code = 404;

    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}
