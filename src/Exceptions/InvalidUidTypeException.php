<?php

namespace Element\Promethium\Exceptions;

class InvalidUidTypeException extends \Exception {

    public function errorMessage() {

        return "Type is not valid, use either OTP or Uid";
    }
}