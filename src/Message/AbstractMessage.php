<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午12:20
 */
namespace QyWechat\Message;

use QyWechat\Support\Attribute;

/**
 * Class AbstractMessage.
 */
abstract class AbstractMessage extends Attribute
{
    /**
     * Message type.
     * @var string
     */
    protected $type;

    /**
     * Message id.
     * @var int
     */
    protected $id;

    /**
     * Message target user id
     * @var string
     */
    protected $toUserName;

    /**
     * Message sender id
     * @var string
     */
    protected $fromUserName;

    /**
     * Message attributes.
     * @var array
     */
    protected $properties = [];

    /**
     * Return type name message.
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Magic getter.
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return parent::__get($property);
    }

    /**
     * Magic setter.
     * @param string $property
     * @param mixed $value
     * @return AbstractMessage
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            parent::__set($property, $value);
        }

        return $this;
    }
}
