<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Description of ${name}
 *
 * @version $id$
 * @author peter.ho
 */
class ArrayHelper
{

    /**
     * 
     * @param type $array
     * @param type $index
     * @return type
     */
    public static function indexBy($array, $index)
    {
        $newArray = array();
        foreach ($array as $row) {
            $newArray[ $row[$index] ] = $row;
        }
        return $newArray;
    }

    /**
     * 
     * @param type $array
     * @param string $index Multiple
     * @return type
     */
    public static function indexByNested($array)
    {
        $newArray = array();
        $indexes = func_get_args();
        $index = $indexes[1];
        foreach ($array as $row) {
            if (! isset($newArray[ $row[$index] ])) {
                $newArray[ $row[$index] ] = array();
            }
            $newArray[ $row[$index] ][] = $row;
        }
        if (count($indexes) > 2) {
            array_splice($indexes, 1, 1);
            foreach ($newArray as $index => $row) {
                $newArray[ $index ] = call_user_func_array(array('static', __FUNCTION__), $indexes);
            }
        }
        return $newArray;
    }

    /**
     * Init an array if the param is not an array
     * @param array $array
     */
    public static function newArray(&$array)
    {
        if (!is_array($array)) {
            $array = array();
        }
    }

    /**
     * return all key in json rescursively, <br />
     * * sub key will be prepended by parent key + $seperator
     * @param array $array
     * @param boolean $getValue default: true
     * @param string $seperator default: "::"
     * @return array
     */
    public static function rescursiveToSingle($array, $getValue = true, $seperator = '::')
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
        $result = array ();
        foreach ($iterator as $key => $value) {
            // Build long key name based on parent keys
            for ($i = $iterator->getDepth() - 1; $i >= 0; $i--) {
                $key = $iterator->getSubIterator($i)->key() . $seperator . $key;
            }
            if ($getValue) {
                $result[ $key ] = $value;
            } else {
                $result[] = $key;
            }
        }
        return $result;
    }

    public static function singleToRescursive($array, $seperator = '::')
    {
        $result = array();
        foreach ($array as $key => $value)
        {
            $keyAllLevel = explode($seperator, $key);
            static::access($result, $keyAllLevel, $value);

        }
        return $result;
    }

    /**
     * Set value into nested array.
     * 
     * @param array $array the storage
     * @param array $keys array of key in parent > child order
     * @param mixed $value the value to set
     */
    private static function accessSet(&$array, $keys, $value)
    {
        if (!is_array($array)) {
            $array = array();
        }
        if (count($keys) === 1) {
            $array[ $keys[0] ] = $value;
        } else {
            if (! isset($array[ $keys[0] ])) {
                $array[ $keys[0] ] = array();
            }
            $nextKey = array_shift($keys);
            static::access($array[ $nextKey ], $keys, $value);
        }
    }

}