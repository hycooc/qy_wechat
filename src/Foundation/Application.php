<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Date: 2016/9/8
 * Time: 14:55
 */
namespace QyWeChat\Foundation;

use Doctrine\Common\Cache\FilesystemCache;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Pimple\Container;
use QyWeChat\Core\AccessToken;
use QyWeChat\Core\Http;
use QyWeChat\Support\Log;
use Symfony\Component\HttpFoundation\Request;

class Application extends Container
{
    //服务集合
    protected $providers = [
        ServiceProviders\ServerServiceProvider::class,
        ServiceProviders\NoticeServiceProvider::class
    ];

    /**
     * 构造方法
     * @param array $config
     */
    public function __construct($config)
    {
        //调用父类构造函数
        parent::__construct();

        //设置配置信息
        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        //判断是否开启错误信息
        if ($this['config']['debug']) {
            error_reporting(E_ALL);
        }

        //注册provideers
        $this->registerProviders();

        //注册基础providers
        $this->registerBaseProviders();

        //初始化日志
        $this->initializeLogger();

        //设置http基础参数
        Http::setDefaultOptions($this['config']->get('guzzle', ['timeout' => 5.0]));

        foreach (['corpid', 'corpsecret'] as $key) {
            !isset($config[$key]) || $config[$key] = '***' . substr($config[$key], -5);
        }

        Log::debug('Current config:', $config);
    }

    /**
     * 添加 provider.
     * @param $provider
     * @return $this
     */
    public function addProvider($provider)
    {
        array_push($this->providers, $provider);

        return $this;
    }

    /**
     * 设置provider
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        $this->providers = [];

        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * 获取所有provider
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @注册 providers.
     */
    private function registerProviders()
    {
        //循环注册服务
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * @注册基础provider
     */
    private function registerBaseProviders()
    {
        //加载request服务
        $this['request'] = function () {
            return Request::createFromGlobals();
        };

        //加载cache服务
        $this['cache'] = function () {
            return new FilesystemCache(sys_get_temp_dir());
        };

        //加载获取accessToken服务
        $this['access_token'] = function () {
            return new AccessToken(
                $this['config']['corpid'],
                $this['config']['corpsecret'],
                $this['cache']
            );
        };
    }

    /**
     * Initialize logger.
     */
    private function initializeLogger()
    {
        if (Log::hasLogger()) {
            return;
        }

        $logger = new Logger('QyWeChat');

        if (!$this['config']['debug'] || defined('PHPUNIT_RUNNING')) {
            $logger->pushHandler(new NullHandler());
        } elseif ($logFile = $this['config']['log.file']) {
            $logger->pushHandler(new StreamHandler($logFile, $this['config']->get('log.level', Logger::WARNING)));
        }

        Log::getLogger($logger);
    }
}