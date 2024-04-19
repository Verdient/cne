<?php

declare(strict_types=1);

namespace Verdient\Cne;

use Verdient\http\Request as HttpRequest;

/**
 * 请求
 * @author Verdient。
 */
class Request extends HttpRequest
{
    /**
     * 客户端编号
     * @author Verdient。
     */
    public string $icId = '';

    /**
     * 访问秘钥
     * @author Verdient。
     */
    public string $secret = '';

    /**
     * 请求名称
     * @author Verdient。
     */
    public string $requestName = '';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function send(): Response
    {
        $timestamp = round(microtime(true) * 1000);
        $this->addBody('RequestName', $this->requestName);
        $this->addBody('icID', $this->icId);
        $this->addBody('TimeStamp', $timestamp);
        $this->addBody('MD5', md5($this->icId . $timestamp . $this->secret));
        return new Response(parent::send());
    }
}
