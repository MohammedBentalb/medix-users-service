<?php

namespace App\Exceptions;

use Exception;

class WrongLoginPortalException extends Exception {
    protected $message = 'Wrong Login Portal';
    protected $code = 400;

    public function __construct(string $message= '', string $code = '') {
        parent::__construct($message ?: $this->message, $code ?: $this->code);
    }
}