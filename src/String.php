<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Description of String
 *
 * @author peter.ho
 */
class String
{

    /**
     * Shortcut to replace all kinds of line-break by $to
     * 
     * @param string $msg
     * @param string $to <b>default</b>: '&lt;br /&gt;'
     * @return string
     */
    public static function stripLineBreak($msg, $to = '<br />')
    {
        return str_replace(
            array("\r", "\n", "\r\n"),
            $to,
            $msg
        );
    }

    /**
     * Generates a random string of given $length.
     *
     * @param Integer $length The string length.
     * @return String The randomly generated string.
     */
    public static function randomString($length = 32)
    {
        return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789'), 0, $length);
    }

    /**
     * Return a salty hash
     * @param string $str
     * @return string
     */
    public static function saltyHash()
    {
        return sha1(APP_HASH_KEY . implode('---', func_get_args()));
    }

    /**
     * return a encrypted string with base64_encode
     * @param string $str
     * @return string
     */
    public static function encryptWithBase64($str)
    {
        $aes = new \Crypt_AES();
        $aes->setKey(APP_CRYPT_KEY);
        return base64_encode($aes->encrypt($str));
    }

    /**
     * return the decrypted string with a base64_decode
     * @param string $str
     * @return string
     */
    public static function decryptWithBase64($str)
    {
        $aes = new \Crypt_AES();
        $aes->setKey(APP_CRYPT_KEY);
        return $aes->decrypt(base64_decode($str));
    }

}
