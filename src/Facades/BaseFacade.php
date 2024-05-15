<?php

namespace Element\Unique\Facades;

abstract class BaseFacade {

    protected static $container;

    public static function setContainer($container) {

        static::$container = $container;
    }

    public static function getFacadeInstance() {

        $accessor = static::getFacadeAccessor();

        return static::$container[$accessor];
    }

    public static function __callStatic($method, $arguments) {

        $instance = static::getFacadeInstance();

        return $instance->$method(...$arguments);
    }
}