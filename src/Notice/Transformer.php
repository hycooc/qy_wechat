<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午12:20
 */
namespace QyWeChat\Notice;

use QyWeChat\Message\AbstractMessage;
use QyWeChat\Message\News;
use QyWeChat\Message\Text;

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

        $handle = 'transform' . substr($class, strlen('QyWeChat\Message\\'));

        return method_exists($this, $handle) ? $this->$handle($message) : [];
    }

    /**
     * @param AbstractMessage $message
     * @return array
     */
    public function transformText(AbstractMessage $message)
    {
        return [
            'text' => [
                'content' => $message->get('content')
            ]
        ];
    }

    /**
     * @param AbstractMessage $message
     * @return array
     */
    public function transformImage(AbstractMessage $message)
    {
        return [
            'image' => [
                'media_id' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * @param AbstractMessage $message
     * @return array
     */
    public function transformVideo(AbstractMessage $message)
    {
        $response = [
            'video' => [
                'media_id' => $message->get('media_id'),
                'title' => $message->get('title'),
                'description' => $message->get('description'),
            ],
        ];

        return $response;
    }

    /**
     * @param AbstractMessage $message
     * @return array
     */
    public function transformVoice(AbstractMessage $message)
    {
        return [
            'voice' => [
                'media_id' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform news message.
     * @param array|\QyWeChat\Message\News $news
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
                'title' => $item->get('title'),
                'description' => $item->get('description'),
                'url' => $item->get('url'),
                'picurl' => $item->get('pic_url'),
            ];
        }

        return [
            'news' => [
                'articles' => $articles
            ],
        ];
    }
}
