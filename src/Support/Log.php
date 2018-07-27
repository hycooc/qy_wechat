<?php

/**
 * Created by PhpStorm.
 * User: baoerge
 * Date: 2016/9/8
 * Time: 14:55
 */
namespace Hycooc\QyWechat\Support;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class Log.
 */
class Log
{
    /**
     * Logger instance.
     * @var \Psr\Log\LoggerInterface
     */
    protected static $logger;

    /**
     * Return the logger instance.
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger(Logger $logger = null)
    {
        return self::$logger ? : ($logger ? self::$logger = $logger : self::$logger = self::createDefaultLogger());
    }

    /**
     * Set logger.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    /**
     * Tests if logger exists.
     * @return bool
     */
    public static function hasLogger()
    {
        return self::$logger ? true : false;
    }

    /**
     * Forward call.
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return forward_static_call_array([self::getLogger(), $method], $args);
    }

    /**
     * Forward call.
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([self::getLogger(), $method], $args);
    }

    /**
     * Make a default log instance.
     * @return \Monolog\Logger
     */
    private static function createDefaultLogger()
    {
        $log = new Logger('QyWechat');

        if (defined('PHPUNIT_RUNNING')) {
            $log->pushHandler(new NullHandler());
        } else {
            $log->pushHandler(new ErrorLogHandler());
        }

        return $log;
    }
}
