<?php

namespace Element\Unique;

use Element\Unique\Generators\Auth\OTP;
use Element\Unique\Generators\Software\LicenseKey;

class Generate {

    /**
     * Generate properties
     */
    protected int $length       = 12;                                   // Default length
    protected string $baseChars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';   // Setting the allowed characters to be used
    protected string $format    = '4444';                               // Characters in each segment, max 5 segments
    protected string $prefix    = '';                                   // Specify if the uuid should have a prefix attached to it in the front?
    protected string $name      = '';                                   // Name of the person or company in which the key is generated for?
    protected string $software  = '';                                   // Name of the software in which the key is generated for?

    /**
     * Generate constructor.
     *
     * @param LicenseKey $licenseKey
     * @param OTP $otp
     */
    public function __construct(LicenseKey $licenseKey, OTP $otp) {

        $this->softwareLicenseKey   = $licenseKey;
        $this->authOTP              = $otp;
    }


}