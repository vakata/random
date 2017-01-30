<?php

namespace vakata\random;

/**
 * A random data generator class.
 */
class Generator
{
    const HIGH = 1;
    const MEDIUM = 2;
    const LOW = 4;
    const ALL = 7;
    /**
     * Generate random bytes.
     * @param  integer $length   amount of bytes to generate
     * @param  integer $strength bitflag of which sources to use by strength (1-high, 2-medium, 4-low), default to 7
     * @return string            the random bytes
     */
    public static function bytes($length = 64, $strength = null)
    {
        if (!$strength) {
            $strength = static::ALL;
        }

        $size = 64;
        $seeds = [];

        // high
        if (($strength & static::HIGH)) {
            // random_bytes() - PHP7
            if (function_exists('random_bytes')) {
                $seeds[] = random_bytes($size);
            }

            // openssl
            if (function_exists('openssl_random_pseudo_bytes')) {
                $seeds[] = openssl_random_pseudo_bytes($size);
            }
        }

        // medium
        if (($strength & static::MEDIUM)) {
            // /dev/urandom (do not use /dev/random as not enough entropy will block reads)
            $file = '/dev/urandom';
            if (@file_exists($file) && ($file = @fopen($file, 'rb'))) {
                if (function_exists('stream_set_read_buffer')) {
                    stream_set_read_buffer($file, 0);
                }
                $seeds[] = fread($file, $size);
                fclose($file);
            }
        }

        // low
        if (($strength & static::LOW)) {
            // uniqid
            $tmp = '';
            while (strlen($tmp) < $size) {
                $tmp = uniqid($tmp, true);
            }
            $seeds[] = substr($tmp, 0, $size);

            // mt_rand()
            $tmp = '';
            for ($i = 0; $i < $size; ++$i) {
                $tmp .= chr((mt_rand() ^ mt_rand()) % 256);
            }
            $seeds[] = $tmp;

            // rand()
            $tmp = '';
            for ($i = 0; $i < $size; ++$i) {
                $tmp .= chr((rand() ^ rand()) % 256);
            }
            $seeds[] = $tmp;
        }

        if (!count($seeds)) {
            throw new \Exception('No random sources available for specified strength');
        }

        // combine seeds
        $result = hash_hmac('sha512', $seeds[0], '', true);
        for ($i = 1; $i < count($seeds); ++$i) {
            $result ^= hash_hmac('sha512', $seeds[$i], $seeds[$i - 1], true);
        }
        while (strlen($result) < $length) {
            $result .= static::bytes($length - strlen($result), $strength);
        }
        if (strlen($result) > $length) {
            $result = substr($result, 0, $length);
        }

        return $result;
    }
    /**
     * Generate a random string.
     * @param  integer $length     the string length
     * @param  string  $characters chars to include (for example `"ABCDEF0123456789"`)
     * @return string              the random string
     */
    public static function string(
        $length = 32,
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        $rand = static::bytes($length * 2);
        $lngt = mb_strlen($characters, 'UTF-8');
        $rslt = '';
        for ($i = 0; $i < strlen($rand); ++$i) {
            $rslt .= mb_substr($characters, ord($rand[$i]) % $lngt, 1, 'UTF-8');
        }

        return mb_substr($rslt, 0, $length, 'UTF-8');
    }
    /**
     * Generate a random number from a range.
     * @param  integer $min the minimum number (defaults to 0)
     * @param  integer $max the maximum number (defaults to PHP_INT_MAX)
     * @return integer      the random number
     */
    public static function number($min = 0, $max = PHP_INT_MAX)
    {
        if ($max === $min) {
            return $max;
        }
        $rand = static::bytes(4);
        $rand = hexdec(bin2hex($rand));

        return $min + abs($rand % ($max - $min + 1));
    }
    public static function uuid()
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
