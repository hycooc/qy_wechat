<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Date: 2016/9/10
 * Time: 11:46
 */
namespace Hycooc\QyWechat\Message;

class Voice extends AbstractMessage
{
    /**
     * Message type.
     * @var string
     */
    protected $type = 'voice';

    /**
     * Properties.
     * @var array
     */
    protected $properties = ['media_id'];

    /**
     * Set media_id.
     * @param $mediaId
     * @return $this voice
     */
    public function media($mediaId)
    {
        $this->setAttribute('media_id', $mediaId);

        return $this;
    }
}