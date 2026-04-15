<?php

namespace App\Exceptions;

use Exception;

class DuplicatedNationalIdException extends Exception {
    protected $message = 'This national ID is already registered';
    protected $code = 409;

    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}
