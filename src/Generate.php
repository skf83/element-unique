<?php

namespace Element\Unique;

use Element\Unique\Helpers\Software\LicenseKey;

class Generate {

    /**
     * Generate params
     */
    protected int $length       = 12;                                   // Default length
    protected string $baseChars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';   // Setting the allowed characters to be used
    protected string $format    = '4444';                               // Characters in each segment, max 5 segments
    protected string $name      = '';                                   // Name of the person or company in which the key is generated for?
    protected string $software  = '';                                   // Name of the software in which the key is generated for?

    /**
     * Generate constructor.
     *
     * @param LicenseKey $softwareLicense
     */
    public function __construct(LicenseKey $softwareLicense) {

        $this->softwareLicense = $softwareLicense;
    }

    /**
     * @return array
     */
    public function twoFactorRecoveryCodes(): array {

        $tokens = [];

        for ($key = 0 ; $key < 10; $key++) {

            $tokens[] = strtolower($this->softwareLicenseKey(16, 55, '', ''));
        }

        return $tokens;
    }

    /**
     * @return string
     */
    public function otp(): string {

        return rand(100,999) . '-' . rand(100,999);
    }

    /**
     * @param $length
     * @param $format
     * @param $name
     * @param $software
     *
     * @return string
     */
    public function softwareLicenseKey($length, $format, $name, $software): string {

        $keylength  = $length ?? $this->length;
        $keyformat  = $format ?? $this->format;
        $name       = $name ?? $this->name;
        $software   = $software ?? $this->software;

        $initlength = $this->softwareLicense->initLen($keylength);
        $initcode   = $this->softwareLicense->initCode($initlength, $this->baseChars);
        $fullcode   = $this->softwareLicense->extendCode($initcode, $software, $name, $keylength);

        return $this->softwareLicense->formatLicense($fullcode, $keyformat, $keylength);
    }

    /**
     * @param string $security
     *
     * @return string
     */
    public function token(string $security = PASSWORD_DEFAULT): string {

        return password_hash(uniqid(), $security);
    }

    /**
     * @param string $prefix
     * @param bool $entropy
     *
     * @return string
     */
    public function uniqid(string $prefix = '', bool $entropy = false): string {

        return uniqid($prefix, $entropy);
    }

    /**
     * @return string
     */
    public function uuid4(): string {

        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

}