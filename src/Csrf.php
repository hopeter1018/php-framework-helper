<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Description of FormHelper
 *
 * @author peter.ho
 */
class Csrf
{

// <editor-fold defaultstate="collapsed" desc="CSRF">

    /**
     * Prefix of the session
     */
    CONST SESSION_PREFIX = 'CSRF::';
    /**
     * Max no. of csrf token with same name
     */
    CONST SESSION_MAX = 10;
    /**
     * Minutes to expire a csrf token
     */
    CONST SESSION_EXPIRE = 15;

    /**
     * 
     * @param string $tokenName
     * @param boolean $noMax
     * @return string
     */
    public static function getToken($tokenName = '', $noMax = false)
    {
        if (! isset($_SESSION[ static::SESSION_PREFIX . $tokenName ])) {
            $_SESSION[ static::SESSION_PREFIX . $tokenName ] = array();
        } elseif ($noMax !== true and count($_SESSION[ static::SESSION_PREFIX . $tokenName ]) > static::SESSION_MAX) {
            HttpResponse::setErrorMessage('Too many csrf token generated');
        }
        $token = base64_encode(time() . String::randomString());
        $_SESSION[ static::SESSION_PREFIX . $tokenName ][ $token ] = 1;
        return $token;
    }

    public static function doClean($tokenName = '')
    {
        unset($_SESSION[ static::SESSION_PREFIX . $tokenName ]);
    }

    public static function doValidate($value, $tokenName = '')
    {
        if ( !isset( $_SESSION[ static::SESSION_PREFIX . $tokenName ] ) 
            or in_array($value, $_SESSION[ static::SESSION_PREFIX . $tokenName ])
        ) {
            throw new \Exception( 'CSRF token is missing or not matched' );
        } else {
            unset($_SESSION[ static::SESSION_PREFIX . $tokenName ] [ $value ]);
            if ( intval( substr( base64_decode( $value ), 0, 10 ) ) + (self::SESSION_EXPIRE * 60) < time() ) {
                throw new \Exception('CSRF token expired');
            }
        }
    }

// </editor-fold>

}
