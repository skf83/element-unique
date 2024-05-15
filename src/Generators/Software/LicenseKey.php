<?php

namespace Element\Unique\Generators\Software;

class LicenseKey {

    /**
     * @param $length
     *
     * @return int|mixed
     */
    function initLen($length) {

        $initlen = intval($length / 3);
        $initlen = max($initlen, 1);

        return $initlen;
    }

    /**
     * @param $length
     * @param $basechar
     *
     * @return string
     */
    function initCode($length, $basechar): string {

        $list       = $basechar;
        $lenlist    = strlen($list) - 1; //count start from 0
        $codestring = "";
        $length     = max($length, 1);

        if ($length > 0) {

            while (strlen($codestring) < $length) {

                $codestring .= $list[mt_rand(0, $lenlist)];
            }
        }

        return $codestring;
    }

    function extendCode($initcode, $software, $name, $length) {

//        $p1str      = $this->sumDigit($initcode);
//        $p1str .= $this->add32($initcode, $name . "abhishek" . $software);
        $p1str      = $this->sumDigit($initcode) . $this->add32($initcode, $name . $software);

        $p1str      = strtoupper($p1str);
        $p1str      = str_replace(array("0", "1", "O", "I",),
            array("", "", "", "",),
            $p1str);
        $p1len = strlen($p1str);
        $extrabit = "";
        $i = 0;

        while (strlen($extrabit) < $length - 2) {

            $extrabit .= substr($p1str, $i, 1);
            $extrabit .= substr($p1str, $p1len - $i - 1, 1);
            $i++;

            if (defined('LKM_DEBUG')) echo "$p1str $extrabit<br/>";
        }

        return $initcode . $extrabit . "6F75";
    }

    /**
     * @param $str
     *
     * @return int|mixed|string
     */
    function sumDigit($str) {

        $a = str_split($str);
        $sum = 0;

        for ($i = 0; $i < count($a); $i++) {

            $sum = $sum + base_convert($a[$i], 36, 10);
        }

        $sum = str_replace(array("0", "1", "O", "I", "o", "i"),
            array("AZ", "BY", "29", "38", "29", "38",),
            $sum);

        if (defined('LKM_DEBUG')) echo " sumDigit $str = $sum<br/>";

        return $sum;
    }

    /**
     * @param $a
     * @param $b
     *
     * @return mixed|string
     */
    function add32($a, $b) {

        $sum = base_convert($a, 36, 10) + base_convert($b, 36, 10);
        $sum32 = base_convert($sum, 10, 36);

        $sum32 = str_replace(array("0", "1", "O", "I", "o", "i"),
            array("", "", "", "", "", "",),
            $sum32);

        if (defined('LKM_DEBUG')) echo " ADD32 $a + $b = $sum32<br/>";

        return $sum32;
    }

    /**
     * @param $serial
     * @param $format
     * @param $length
     *
     * @return string
     */
    function formatLicense($serial, $format, $length) {

        $farray = str_split($format);
        $sarray = str_split($serial);
        $s0 = $farray[0];
        $s1 = $farray[1] + $s0;
        $s2 = $farray[2] + $s1;
        $s3 = $farray[3] + $s2;
        $s4 = $farray[4] + $s3;
        $scount = $length;
        $sformated = "";
        for ($i = 0; $i < $scount; $i++) {
            if ($i == $s0 || $i == $s1 || $i == $s2 || $i == $s3 || $i == $s4)
                $sformated .= "-";
            $sformated .= $sarray[$i];
        }
        if (defined('LKM_DEBUG')) echo " $serial FORMATED AS $sformated<br/>";

        return $sformated;
    }
}