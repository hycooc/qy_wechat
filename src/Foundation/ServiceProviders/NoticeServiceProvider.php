<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午4:31
 */

namespace QyWechat\Foundation\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use QyWechat\Notice\Notice;

class NoticeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['notice'] = function ($pimple) {
            return new Notice($pimple['access_token']);
        };
    }
}