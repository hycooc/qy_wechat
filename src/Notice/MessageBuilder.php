<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午2:35
 */
namespace Hycooc\QyWechat\Notice;

use Hycooc\QyWechat\Core\Exceptions\InvalidArgumentException;
use Hycooc\QyWechat\Core\Exceptions\RuntimeException;
use Hycooc\QyWechat\Message\AbstractMessage;
use Hycooc\QyWechat\Message\Raw as RawMessage;
use Hycooc\QyWechat\Message\Text;

/**
 * Class MessageBuilder.
 */
class MessageBuilder
{
    /**
     * Message to send.
     * @var \Hycooc\QyWechat\Message\AbstractMessage;
     */
    protected $message;

    /**
     * Message send user id.
     * @var string
     */
    protected $touser;

    /**
     * Message send party id.
     * @var string
     */
    protected $toparty;

    /**
     * Message send tag id.
     * @var string
     */
    protected $totag;

    /**
     * Message from agent id.
     * @var string
     */
    protected $agentid;

    /**
     * Staff instance.
     * @var \Hycooc\QyWechat\Notice\Notice
     */
    protected $notice;

    /**
     * MessageBuilder constructor.
     * @param \Hycooc\QyWechat\Notice\Notice $notice
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Set message to send.
     * @param string|AbstractMessage $message
     * @return MessageBuilder
     * @throws InvalidArgumentException
     */
    public function message($message)
    {
        if (is_string($message)) {
            $message = new Text(['content' => $message]);
        }

        $this->message = $message;

        return $this;
    }

    /**
     * Set from agent id.
     * @param $agentid
     * @return $this
     */
    public function fromAgent($agentid)
    {
        $this->agentid = intval($agentid);

        return $this;
    }

    /**
     * Set send user id.
     * @param string $userIds
     * @return MessageBuilder
     */
    public function toUser($userIds)
    {
        $this->touser = is_array($userIds) ? implode('|', $userIds) : $userIds;

        return $this;
    }

    /**
     * Set send party id.
     * @param string $partyIds
     * @return MessageBuilder
     */
    public function toParty($partyIds)
    {
        $this->toparty = is_array($partyIds) ? implode('|', $partyIds) : $partyIds;

        return $this;
    }

    /**
     * Set send tag id.
     * @param string $tagIds
     * @return MessageBuilder
     */
    public function toTag($tagIds)
    {
        $this->totag = is_array($tagIds) ? implode('|', $tagIds) : $tagIds;

        return $this;
    }

    /**
     * Send the message.
     * @return bool
     * @throws RuntimeException
     */
    public function send()
    {
        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        $transformer = new Transformer();

        if ($this->message instanceof RawMessage) {
            $message = $this->message->get('content');
        } else {
            $content = $transformer->transform($this->message);

            $sendData = ['agentid' => $this->agentid];
            foreach (['touser', 'toparty', 'totag'] as $nameKey) {
                if (!empty($this->{$nameKey})) {
                    $sendData[$nameKey] = $this->{$nameKey};
                }
            }

            $message = array_merge($sendData, $content, ['msgtype' => is_array($this->message) ? 'news' : $this->message->getType()]);
        }

        return $this->notice->send($message);
    }

    /**
     * Return property.
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
