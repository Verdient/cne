
<?php

declare(strict_types=1);

use Verdient\http\serializer\query\RFC1738Serializer;
use Verdient\http\serializer\SerializerInterface;

/**
 * 查询参数序列化器
 * @author Verdient。
 */
class QuerySerializer implements SerializerInterface
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public static function serialize($data): string
    {
        if (count($data) === 1) {
            return array_keys($data)[0];
        }
        return RFC1738Serializer::serialize($data);
    }
}
