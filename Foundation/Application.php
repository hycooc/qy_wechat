<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Date: 2016/9/8
 * Time: 14:55
 */
namespace QyWecaht\Foundation;


use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;

class Appliacation extends Container
{

    protected $providers = [

    ];

    public function __construct($config)
    {
        parent::__construct();

        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        //是否开启debug
        if ($this['config']['debug']) {
            error_reporting(E_ALL);
        }


    }

    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }

    }

    private function registerBaseProviders()
    {
        $this['request'] = function () {
          return Request::createFromGlobals();
        };
    }


}