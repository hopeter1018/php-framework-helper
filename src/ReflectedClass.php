<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

use ReflectionClass;
use stdClass;

/**
 * Description of PhpNamespace
 * @todo add more shortcut to get information from the reflection.
 * 
 * @version $id$
 * @author peter.ho
 */
final class ReflectedClass
{

    /**
     *
     * @var ReflectionClass
     */
    public $refl = null;

    /**
     *
     * @var \Hopeter1018\Framework\ManagerModule\ModuleConfigure|\Hopeter1018\Framework\ManagerModule\ManagerConfigure|\Hopeter1018\Framework\ManagerModule\IModuleConfigure|\Hopeter1018\Framework\ManagerModule\IManagerConfigure
     */
    public $obj = null;

    public function __construct($obj, ReflectionClass $refl)
    {
        $this->obj = $obj;
        $this->refl = $refl;
    }

    /**
     * 
     * @param stdClass $obj
     * @return ReflectedClass
     */
    public static function get($obj)
    {
        return new static($obj, new ReflectionClass($obj));
    }

}
