<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午12:20
 */
namespace QyWechat\Server;

use QyWechat\Message\AbstractMessage;
use QyWechat\Message\News;
use QyWechat\Message\Text;

/**
 * Class Transformer.
 */
class Transformer
{
    /**
     * transform message to XML.
     * @param array|string|AbstractMessage $message
     * @return array
     */
    public function transform($message)
    {
        if (is_array($message)) {
            $class = News::class;
        } else {
            if (is_string($message)) {
                $message = new Text(['content' => $message]);
            }

            $class = get_class($message);
        }

        $handle = 'transform' . substr($class, strlen('QyWechat\Message\\'));

        return method_exists($this, $handle) ? $this->$handle($message) : [];
    }

    /**
     * Transform text message.
     * @return array
     */
    public function transformText(AbstractMessage $message)
    {
        return [
            'Content' => $message->get('content'),
        ];
    }

    /**
     * Transform image message.
     * @return array
     */
    public function transformImage(AbstractMessage $message)
    {
        return [
            'Image' => [
                'MediaId' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform video message.
     * @return array
     */
    public function transformVideo(AbstractMessage $message)
    {
        $response = [
            'Video' => [
                'MediaId'     => $message->get('media_id'),
                'Title'       => $message->get('title'),
                'Description' => $message->get('description'),
            ],
        ];

        return $response;
    }

    /**
     * Transform voice message.
     * @return array
     */
    public function transformVoice(AbstractMessage $message)
    {
        return [
            'Voice' => [
                'MediaId' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform transfer message.
     * @return array
     */
    public function transformTransfer(AbstractMessage $message)
    {
        $response = [];

        // 指定客服
        if ($message->get('account')) {
            $response['TransInfo'] = [
                'KfAccount' => $message->get('account'),
            ];
        }

        return $response;
    }

    /**
     * Transform news message.
     * @param array|\QyWechat\Message\News $news
     * @return array
     */
    public function transformNews($news)
    {
        $articles = [];

        if (!is_array($news)) {
            $news = [$news];
        }

        foreach ($news as $item) {
            $articles[] = [
                'Title'       => $item->get('title'),
                'Description' => $item->get('description'),
                'Url'         => $item->get('url'),
                'PicUrl'      => $item->get('pic_url'),
            ];
        }

        return [
            'ArticleCount' => count($articles),
            'Articles'     => $articles,
        ];
    }
}
