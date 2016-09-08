<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午12:20
 */
namespace QyWeChat\Message;

/**
 * Class News.
 */
class News extends AbstractMessage
{
    /**
     * Message type.
     * @var string
     */
    protected $type = 'news';

    /**
     * Properties.
     * @var array
     */
    protected $properties = [
        'title',
        'description',
        'url',
        'image',
    ];
    /**
     * Aliases of attribute.
     * @var array
     */
    protected $aliases = [
        'image' => 'picurl',
    ];
}
