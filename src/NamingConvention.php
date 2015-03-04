<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Description of NamingConvention
 * 
 * Provide a series of static function to transform wordings.
 * 
 * dash:   user-manager
 * camel:  userManager
 * pascal: UserManager
 * spinal:  user_manager
 * train:  User_Manager
 * humans: User Manager
 * from*   string > array
 * to*     array > string
 * {case}To{Case} @return string
 *
 * @author peter.ho
 */
class NamingConvention
{

// <editor-fold defaultstate="collapsed" desc="From(s)">

    /**
     * split user-manager into array('user', 'manager')
     * @param string $string
     * @return array|string[]
     */
    public static function fromDash($string)
    {
        return explode('-', $string);
    }

    /**
     * split user_manager / User_Manager into array('user', 'manager')
     * @param string $string
     * @return array|string[]
     */
    public static function fromSpinalOrTrain($string)
    {
        return explode('_', $string);
    }

    /**
     * split User Manager into array('user', 'manager')
     * @param string $string
     * @return array|string[]
     */
    public static function fromHuman($string)
    {
        $match = array ();
        preg_match_all("/ \w+/", strtolower($string), $match);
        return array_map('trim', array_map('trim', $match[0]));
    }

    /**
     * split userManager / UserManager into array('user', 'manager')
     * @param string $string
     * @return array|string[]
     */
    public static function fromCamelOrPascal($string)
    {
        $match = array ();
        preg_match_all("/[A-Z][^A-Z]+/", ucfirst($string), $match);
        return array_map('trim', $match[0]);
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="To(s)">

    /**
     * implode array('user', 'manager') into "User Manager"
     * 
     * @param array|string[] $array
     * @return string
     */
    public static function toHuman($array)
    {
        return implode(" ", array_map('ucfirst', $array));
    }

    /**
     * implode array('user', 'manager') into "UserManager"
     * 
     * @param array|string[] $array
     * @return string
     */
    public static function toPascal($array)
    {
        return implode("", array_map('ucfirst', $array));
    }

    /**
     * implode array('user', 'manager') into "userManager"
     * 
     * @param array|string[] $array
     * @return string
     */
    public static function toCamel($array)
    {
        return lcfirst(implode("", array_map('ucfirst', $array)));
    }

    /**
     * implode array('user', 'manager') into "user-manager"
     * 
     * @param array|string[] $array
     * @return string
     */
    public static function toDash($array)
    {
        return implode("-", array_map('strtolower', $array));
    }

    /**
     * implode array('user', 'manager') into "user_manager"
     * 
     * @param array|string[] $array
     * @return string
     */
    public static function toSpinal($array)
    {
        return implode("-", array_map('strtolower', $array));
    }

    /**
     * implode array('user', 'manager') into "User_Manager"
     * 
     * @param array|string[] $array
     * @return string
     */
    public static function toTrain($array)
    {
        return implode("-", array_map('ucfirst', array_map('strtolower', $array)));
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Case to Case">

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="named by function">

    /**
     * String transform from dash to pascal
     * @param string $urlParts
     * @return string
     */
    public static function urlPartsToController($urlParts)
    {
        return static::toPascal(static::fromDash($urlParts));
    }

    /**
     * String transform from dash to camel
     * @param string $urlParts
     * @return string
     */
    public static function urlPartsToMethod($urlParts)
    {
        return static::toCamel(static::fromDash($urlParts));
    }

// </editor-fold>
}
