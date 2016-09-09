<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午2:35
 */
namespace QyWeChat\Notice;

use QyWeChat\Core\AbstractAPI;

class Notice extends AbstractAPI
{
    const API_MESSAGE_SEND = 'https://qyapi.weixin.qq.com/cgi-bin/message/send';

    /**
     * Get message builder.
     *
     * @param \QyWeChat\Message\AbstractMessage|string $message
     *
     * @return \QyWeChat\Notice\MessageBuilder
     *
     * @throws \QyWeChat\Core\Exceptions\InvalidArgumentException
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