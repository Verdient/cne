<?php

declare(strict_types=1);

namespace Verdient\Cne;

use QuerySerializer;
use Verdient\HttpAPI\AbstractClient;

/**
 * 递一
 * @author Verdient。
 */
class Cne extends AbstractClient
{
    /**
     * 客户端编号
     * @author Verdient。
     */
    protected string $icId = '';

    /**
     * 访问秘钥
     * @author Verdient。
     */
    protected string $secret = '';

    /**
     * 代理主机
     * @author Verdient。
     */
    protected ?string $proxyHost = null;

    /**
     * 代理端口
     * @author Verdient。
     */
    protected int|string|null $proxyPort = null;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $request = Request::class;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function request($name): Request
    {
        /** @var Request */
        $request = parent::request('cgi-bin/EmsData.dll?DoApi');
        $request->requestName = $name;
        $request->icId = $this->icId;
        $request->secret = $this->secret;
        if ($this->proxyHost) {
            $request->setProxy($this->proxyHost, empty($this->proxyPort) ? null : intval($this->proxyPort));
        }
        $request->setQuerySerializer(QuerySerializer::class);
        return $request;
    }

    /**
     * 生成面单地址
     * @author Verdient。
     */
    public function generateWaybillUrl(string $number): string
    {
        $timestamp = round(microtime(true) * 1000);
        $query = http_build_query([
            'icID' => $this->icId,
            'cNos' => $number,
            'ptemp' => 'label10x10_0',
            'signature' => md5($this->icId . $timestamp . $this->secret)
        ]);
        return 'https://label.cne.com/CnePrint?' . $query;
    }
}
