<?php

/**
 * Created by PhpStorm.
 * User: baoerge
 * Date: 2016/9/8
 * Time: 14:55
 */

namespace Hycooc\QyWechat\Core;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Hycooc\QyWechat\Core\Exceptions\HttpException;

/**
 * Class AccessToken.
 */
class AccessToken
{
    /**
     * 企业Id
     *
     * @var string
     */
    protected $corpid;

    /**
     * 管理组的凭证密钥
     *
     * @var string
     */
    protected $corpsecret;

    /**
     * Cache. 缓存
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Http instance.
     *
     * @var Http
     */
    protected $http;

    /**
     * Corp name
     *
     * @var
     */
    protected $corp = '';

    /**
     * Query name.
     *
     * @var string
     */
    protected $queryName = 'access_token';

    /**
     * Cache key prefix.
     *
     * @var string
     */
    protected $prefix = 'qywechat.common.access_token.';

    /**
     * get token API UTL
     *
     * @var string
     */
    const API_TOKEN_GET = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken';

    /**
     * Constructor.
     *
     * @param string $corpid
     * @param string $corpsecret
     * @param string $corp
     * @param \Doctrine\Common\Cache\Cache $cache
     */
    public function __construct($corpid, $corpsecret, $corp, Cache $cache = null)
    {
        $this->corpid     = $corpid;
        $this->corpsecret = $corpsecret;
        $this->corp       = $corp;
        $this->cache      = $cache;
    }

    /**
     * Get token from WeChat API.
     *
     * @param bool $forceRefresh
     *
     * @return string
     */
    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->prefix . $this->corpid . $this->corp;

        $cached = $this->getCache()->fetch($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromServer();

            // XXX: T_T... 7200 - 1500
            $this->getCache()->save($cacheKey, $token['access_token'], $token['expires_in'] - 1500);

            return $token['access_token'];
        }

        return $cached;
    }

    /**
     * Return the corpid.
     *
     * @return string
     */
    public function getCorpid()
    {
        return $this->corpid;
    }

    /**
     * Return the corpsecret.
     *
     * @return string
     */
    public function getCorpsecret()
    {
        return $this->corpsecret;
    }

    /**
     * Set cache instance.
     *
     * @param \Doctrine\Common\Cache\Cache $cache
     *
     * @return AccessToken
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Return the cache manager.
     *
     * @return \Doctrine\Common\Cache\Cache
     */
    public function getCache()
    {
        return $this->cache ?: $this->cache = new FilesystemCache(sys_get_temp_dir());
    }

    /**
     * Set the query name.
     *
     * @param string $queryName
     *
     * @return $this
     */
    public function setQueryName($queryName)
    {
        $this->queryName = $queryName;

        return $this;
    }

    /**
     * Return the query name.
     *
     * @return string
     */
    public function getQueryName()
    {
        return $this->queryName;
    }

    /**
     * Return the API request queries.
     *
     * @return array
     */
    public function getQueryFields()
    {
        return [$this->queryName => $this->getToken()];
    }

    /**
     * Get the access token from WeChat server.
     *
     * @throws \Hycooc\QyWechat\Core\Exceptions\HttpException
     * @return array|bool
     */
    public function getTokenFromServer()
    {
        $params = [
            'corpid'     => $this->corpid,
            'corpsecret' => $this->corpsecret,
        ];

        $http = $this->getHttp();

        $token = $http->parseJSON($http->get(self::API_TOKEN_GET, $params));

        if (empty($token['access_token'])) {
            throw new HttpException('Request AccessToken fail. response: ' . json_encode($token, JSON_UNESCAPED_UNICODE));
        }

        return $token;
    }

    /**
     * Return the http instance.
     *
     * @return \Hycooc\QyWechat\Core\Http
     */
    public function getHttp()
    {
        return $this->http ?: $this->http = new Http();
    }

    /**
     * Set the http instance.
     *
     * @param \Hycooc\QyWechat\Core\Http $http
     *
     * @return $this
     */
    public function setHttp(Http $http)
    {
        $this->http = $http;

        return $this;
    }
}
