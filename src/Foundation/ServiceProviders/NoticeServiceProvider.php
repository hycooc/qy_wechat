<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午4:31
 */

namespace QyWeChat\Foundation\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use QyWeChat\Notice\Notice;

class NoticeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['notice'] = function ($pimple) {
            return new Notice($pimple['access_token']);
        };
    }
}