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

    /**
     * return \DateTime with time = 0,0,0
     * 
     * @param \DateTime|string $dateObj
     * @return \DateTime|null
     */
    public static function getDate($dateObj)
    {
        if (null != ($dateTime = static::getDateTime($dateObj))) {
            $dateTime->setTime(0, 0, 0);
            return $dateTime;
        } else {
            return null;
        }
    }

    /**
     * return \DateTime with time
     * 
     * @param \DateTime|string $dateObj
     * @return \DateTime|null
     */
    public static function getDateTime($dateObj)
    {
        if ($dateObj === null
            or (is_object($dateObj) and isset($dateObj->date) and $dateObj->date === '')
        ) {
            return null;
        } else {
            $dateTime = \DateTime::createFromFormat(
                'Y-m-d\TH:i:s.u\Z', 
                ((is_object($dateObj) and isset($dateObj->date) and $dateObj->date != ''))
                    ? $dateObj->date
                    : $dateObj,
                new \DateTimeZone('UTC')
            ); /* @var $dateTime \DateTime */
            if (null === $dateTime or false === $dateTime) {
                $dateTime = \DateTime::createFromFormat(
                    'Y-m-d H:i:s', 
                    ((is_object($dateObj) and isset($dateObj->date) and $dateObj->date != ''))
                        ? $dateObj->date
                        : $dateObj,
                    new \DateTimeZone('UTC')
                ); /* @var $dateTime \DateTime */
                if (null === $dateTime or false === $dateTime) {
                    return null;
                } else {
                    $dateTime->setTimezone(new \DateTimeZone(APP_DEFAULT_TIMEZONE));
                    return $dateTime;
                }
            } else {
                $dateTime->setTimezone(new \DateTimeZone(APP_DEFAULT_TIMEZONE));
                return $dateTime;
            }
        }
    }

    /**
     * 
     * @return \DateTime
     */
    public static function requestTime()
    {
        return new \DateTime(filter_input(INPUT_SERVER, 'REQUEST_TIME'));
    }

    /**
     * 
     * @return \DateTime
     */
    public static function requestDay()
    {
        return \Carbon\Carbon::instance(static::requestTime())->startOfDay();
    }

    public static function now()
    {
        return new \DateTime();
    }

}
