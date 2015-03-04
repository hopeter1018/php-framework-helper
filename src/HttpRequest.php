<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Set of common functions to manipulate http request informations
 *
 * @version $id$
 * @author peter.ho
 */
class HttpRequest
{

    /**
     * shortcut to json_decode(file_get_contents("php://input"));
     * 
     * @return \stdClass
     */
    public static function getRequestParams()
    {
        $request = json_decode(file_get_contents("php://input"));
//        if (\Zms5\Helpers\RequestHeaderHelper::has('zms-form-upload')) {
//            $request = (object) $_POST;
//        }
        if (APP_IS_DEV and $request == null) {
            $request = (object) $_GET;
        }
        return $request;
    }

    /**
     * Get the requested http header from $_SERVER
     * 
     * @param string $name name of the header in <b>UPPERCASE</b>
     * @return string|null
     */
    public static function getHeader($name)
    {
        if (APP_IS_DEV and strtoupper(str_replace('-', '_', $name)) !== $name) {
            throw new \Exception("HttpRequest::getHeader parameter is not in good format: {$name}");
        }
        return $_SERVER['HTTP_' . $name] ?: null;
    }

}
