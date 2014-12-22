<?php

ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('UTC');

$composerAutoload = realpath(dirname(__FILE__) . '/../vendor/autoload.php');

if (strnatcmp(phpversion(), '5.3') < 0 || !@include($composerAutoload)) {
    function pearStyleAutoloader($className)
    {
        $pathPrefix = 'src' . DIRECTORY_SEPARATOR;
        $classPath = $pathPrefix . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (is_file($classPath)) {
            include $classPath;
            return true;
        }
    }

    spl_autoload_register('pearStyleAutoloader');

}