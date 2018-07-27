<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/1/15
 * Time: 下午10:20
 */
namespace Hycooc\QyWechat\Message;

class TextCard extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'textcard';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['title', 'description', 'url', 'btntxt'];
}