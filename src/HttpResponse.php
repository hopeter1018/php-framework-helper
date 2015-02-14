<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Shortcuts, formatting for response header.<br />
 * 
 * @see \Guzzle\Http\Message\Response
 * @see \Symfony\Component\HttpFoundation\Response
 * @version $id$
 * @author peter.ho
 */
final class HttpResponse
{

    /**
     * return custom error message by response header for zmsForm.js
     * ** Please be reminded the $msg accept html code.
     * @param string $msg
     */
    public static function setFormError($msg)
    {
        header("framework-form-error: $msg", false, 500);
    }

    /**
     * return response header with name "framework-message"
     * @param string $msg
     */
    public static function setErrorMessage($msg)
    {
        $msgFormatted = String::stripLineBreak(var_export($msg, true), " ");
        header("framework-message: $msgFormatted", false, 500);
    }
    
    private static $msgCounter = 0;
    /**
     * 
     * @param string $msgSrc
     * @param string $name
     * @param string $prefix
     */
    public static function addMessage($msgSrc, $name = '__', $prefix = '')
    {
        $msg = String::stripLineBreak(var_export($msgSrc, true), " ");
        if ($name === null) {
            $name = '';
        }
        $index = sprintf('%04d', ++ static::$msgCounter) . '-';
        header("zms-msg-{$index}{$prefix}{$name}: $msg", false);
    }

    /**
     * add new message if IS_DEV
     * @param string $msg
     * @param string $name
     */
    public static function addMessageDev($msg, $name = null)
    {
        if (APP_IS_DEV) {
            static::addMessage($msg, $name);
        }
    }

    /**
     * add new message if IS_DEV or IS_UAT
     * @param string $msg
     * @param string $name
     */
    public static function addMessageUat($msg, $name = null)
    {
        if (APP_IS_UAT or APP_IS_DEV) {
            static::addMessage($msg, $name);
        }
    }

}
