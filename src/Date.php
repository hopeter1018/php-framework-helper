<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Description of Date
 *
 * @author peter.ho
 */
class Date
{
    const MYSQL_DATE = 'Y-m-d';
    const MYSQL_DATE_TIME = 'Y-m-d h:i:s';
    const JS_DATE = 'm/d/Y';
    const JS_DATE_TIME = 'm/d/Y h:i:s';

    public static function requestTime()
    {
        return date('F d, Y G:i:s', $_SERVER['REQUEST_TIME']);
    }

}
