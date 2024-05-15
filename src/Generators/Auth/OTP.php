<?php

namespace Element\Unique\Generators\Auth;

class OTP {

    /**
     * @return string
     */
    function init(): string {

        return rand(100,999) . '-' . rand(100,999);
    }
}