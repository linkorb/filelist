<?php

namespace LinkORB\Component\FileList;

use LinkORB\Component\FileList\Driver\FileSystemDriver;
use LinkORB\Component\FileList\FileList;

class Utils
{

    public static function loadConfig($filename = null)
    {
        $name = 'filelist';
        if (!$filename) {
            if (file_exists($name . '.conf')) {
                $filename = $name . '.conf';
            } elseif (file_exists($_SERVER['HOME'] . '/.' . $name . '.conf')) {
                $filename = $_SERVER['HOME'] . '/.' . $name . '.conf';
            } elseif (file_exists('/etc/' . $name . '.conf')) {
                $filename = '/etc/' . $name . '.conf';
            } else {
                throw new RuntimeException("No configfile detected");
            }
        }

        if (!file_exists($filename)) {
            throw new RuntimeException("Config file not found");
        }
        $config = parse_ini_file($filename, true);
        if (!isset($config['general']['driver'])) {
            throw new RuntimeException("Config file not valid, please check " . $name . ".conf.dist for an example");
        }
        return $config;
    }

    public static function getDriverFromConfig($config)
    {
        $drivername = (string)$config['general']['driver'];
        $driverclassname = 'LinkORB\\Component\\FileList\\Driver\\' . $drivername . 'Driver';
        if (!class_exists($driverclassname)) {
            throw new RuntimeException("Driver class not found or supported: " . $driverclassname);
        }

        switch(strtolower($drivername)) {
            case "filesystem":
                

                $path = (string)$config['filesystem']['path'];

                if (trim($path)=='') {
                    throw new InvalidArgumentException("No path provided for FileSystem driver");
                }


                $driver = new $driverclassname($path);
                break;

            case "objectstorage":

                break;


            default:
                throw new RuntimeException("Unsupported driver: " . $drivername);
                break;

        }

        return $driver;
    }

}