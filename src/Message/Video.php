<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Date: 2016/9/10
 * Time: 11:48
 */
namespace Hycooc\QyWechat\Message;

class Video extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'video';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['media_id', 'title', 'description'];

    /**
     * Set media_id.
     *
     * @param string $mediaId
     *
     * @return Video
     */
    public function media($mediaId)
    {
        $this->setAttribute('media_id', $mediaId);

        return $this;
    }
}