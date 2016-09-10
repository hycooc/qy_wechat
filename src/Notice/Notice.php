<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午2:35
 */
namespace QyWechat\Notice;

use QyWechat\Core\AbstractAPI;

class Notice extends AbstractAPI
{
    /*
     * message send API
     */
    const API_MESSAGE_SEND = 'https://qyapi.weixin.qq.com/cgi-bin/message/send';

    /**
     * Get message builder.
     *
     * @param \QyWechat\Message\AbstractMessage|string $message
     *
     * @return \QyWechat\Notice\MessageBuilder
     *
     * @throws \QyWechat\Core\Exceptions\InvalidArgumentException
     */
    public function message($message)
    {
        $messageBuilder = new MessageBuilder($this);

        return $messageBuilder->message($message);
    }

    /**
     *  Send a message.
     *
     * @param string|array $message
     *
     * @return mixed
     */
    public function send($message)
    {
        //获取accessToken
        $token = $this->accessToken->getToken();
        $url = sprintf('%s?access_token=%s', self::API_MESSAGE_SEND, $token);

        return $this->parseJSON('json', [$url, $message]);
    }
}