<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/1/15
 * Time: 下午10:05
 */
namespace QyWechat\Message;

/**
 * Class File
 *
 * @package QyWechat\Message
 * @Author: baoerge123@163.com
 */
class File extends AbstractMessage
{
    /**
     * Message type.
     * @var string
     */
    protected $type = 'file';

    /**
     * Properties.
     * @var array
     */
    protected $properties = ['media_id'];

    /**
     * Set media_id.
     * @param string $mediaId
     * @return File
     */
    public function media($mediaId)
    {
        $this->setAttribute('media_id', $mediaId);

        return $this;
    }
}