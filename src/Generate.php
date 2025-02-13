<?php

namespace Element\Unique;

use Element\Unique\Helpers\Software\LicenseKey;

/**
 * @property LicenseKey $softwareLicense
 */
class Generate {

    /**
     * Generate constructor.
     *
     * @param LicenseKey $softwareLicense
     */
    public function __construct(LicenseKey $softwareLicense) {

        $this->softwareLicense = $softwareLicense;
    }

    /**
     * @param int $amount
     * @param int $length
     * @param string $format
     *
     * @return array|string
     */
    public static function twoFactorRecoveryCodes(int $amount = 10, int $length = 10, string $format = '55555') {

        $tokens = [];

        foreach (range(1, $amount) as $token) {

            $tokens[] = strtolower(self::softwareLicenseKey($length, $format));
        }

        if (count($tokens) === 1) {

            return $tokens['0'];
        }

        return $tokens;
    }

    /**
     * @return string
     */
    public static function otp(): string {

        return rand(100,999) . '-' . rand(100,999);
    }

    /**
     * @param int $length
     * @param string $format
     * @param string $name
     * @param string $software
     *
     * @return string
     */
    public static function softwareLicenseKey(int $length = 25, string $format = '55555', string $name = '', string $software = ''): string {

        /**
         * DEFAULTS:
         * $length      = 12;
         * $baseChars   = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';   // Setting the allowed characters to be used
         * $format      = '4444';                               // Characters in each segment, max 5 segments
         * $name        = '';                                   // Name of the person or company in which the key is generated for?
         * $software    = '';                                   // Name of the software in which the key is generated for?
         */
        $licenseKey = new LicenseKey;
        $baseChars  = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';   // Setting the allowed characters to be used
        $keylength  = $length;
        $keyformat  = $format;

        $initlength = $licenseKey->initLen($keylength);
        $initcode   = $licenseKey->initCode($initlength, $baseChars);
        $fullcode   = $licenseKey->extendCode($initcode, $software, $name, $keylength);

        return $licenseKey->formatLicense($fullcode, $keyformat, $keylength);
    }

    /**
     * @param string $security
     *
     * @return string
     */
    public static function token(string $security = PASSWORD_DEFAULT): string {

        return password_hash(uniqid(), $security);
    }

    /**
     * @param string $prefix
     * @param bool $entropy
     *
     * @return string
     */
    public static function uniqid(string $prefix = '', bool $entropy = false): string {

        return uniqid($prefix, $entropy);
    }

    /**
     * @return string
     */
    public static function uuid4(): string {

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