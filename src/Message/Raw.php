<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午12:20
 */
namespace QyWeChat\Message;

/**
 * Class Raw.
 */
class Raw extends AbstractMessage
{
    /**
     * @var string
     */
    protected $type = 'raw';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['content'];

    /**
     * Constructor.
     *
     * @param array $content
     */
    public function __construct($content)
    {
        parent::__construct(['content' => strval($content)]);
    }
}
