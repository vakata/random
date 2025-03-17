<?php

namespace vakata\random;

/**
 * A random data generator class.
 */
class Generator
{
    /**
     * Generate random bytes.
     * @param  integer $length   amount of bytes to generate
     * @return string            the random bytes
     */
    public static function bytes(int $length = 64) : string
    {
        return random_bytes($length);
    }
    /**
     * Generate a random string.
     * @param  integer $length     the string length
     * @param  string  $characters chars to include (for example `"ABCDEF0123456789"`)
     * @return string              the random string
     */
    public static function string(
        int $length = 32,
        string $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) : string {
        $rand = static::bytes($length * 2);
        $chrs = preg_split('//u', $characters, -1, PREG_SPLIT_NO_EMPTY);
        $lngt = count($chrs);
        $rslt = '';
        for ($i = 0; $i < $length; ++$i) {
            $rslt .= $chrs[ord($rand[$i]) % $lngt];
        }
        return $rslt;
    }
    /**
     * Generate a random number from a range.
     * @param  integer $min the minimum number (defaults to 0)
     * @param  integer $max the maximum number (defaults to PHP_INT_MAX)
     * @return integer      the random number
     */
    public static function number(int $min = 0, int $max = PHP_INT_MAX) : int
    {
        if ($max === $min) {
            return $max;
        }
        $rand = static::bytes(4);
        $rand = hexdec(bin2hex($rand));

        return $min + abs($rand % ($max - $min + 1));
    }
    public static function uuid() : string
    {
        $hash = bin2hex(static::bytes(16));

        $timeHiVersion = substr($hash, 12, 4);
        $timeHiVersion = hexdec($timeHiVersion) & 0x0fff;
        $timeHiVersion &= ~(0xf000);
        $timeHiVersion |= 4 << 12; // version is 4
        $timeHiVersion = sprintf('%04x', $timeHiVersion);
        $clockHi = hexdec(substr($hash, 16, 2));
        $clockHi = $clockHi & 0x3f;
        $clockHi &= ~(0xc0);
        $clockHi |= 0x80;
        $clockHi = sprintf('%02x', $clockHi);

        return vsprintf(
            '%08s-%04s-%04s-%02s%02s-%012s',
            [
                substr($hash, 0, 8),
                substr($hash, 8, 4),
                $timeHiVersion,
                $clockHi,
                substr($hash, 18, 2),
                substr($hash, 20, 12)
            ]
        );
    }
}
