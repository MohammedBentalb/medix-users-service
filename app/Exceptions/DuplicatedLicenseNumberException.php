<?php

namespace App\Exceptions;

use Exception;

class DuplicatedLicenseNumberException extends Exception {
    protected $message = 'This license number is already registered';
    protected $code = 409;

    public function __construct(string $message = '', int $code = 409) {
        parent::__construct($message ?: $this->message, $code ?: $this->code,);
    }
}
