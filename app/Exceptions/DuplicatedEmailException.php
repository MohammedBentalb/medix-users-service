<?php

namespace App\Exceptions;

use Exception;

class DuplicatedEmailException extends Exception {
    protected $message = 'This email is already in use';
    protected $code = 409;

    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message ?: $this->message, $code    ?: $this->code,);
    }
}
