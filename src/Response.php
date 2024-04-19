<?php

declare(strict_types=1);

namespace Verdient\Cne;

use Verdient\http\Response as HttpResponse;
use Verdient\HttpAPI\AbstractResponse;
use Verdient\HttpAPI\Result;

/**
 * 响应
 * @author Verdient。
 */
class Response extends AbstractResponse
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function normailze(HttpResponse $response): Result
    {
        $result = new Result();
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $result->data = $body;
        $result->isOK = false;
        if ($statusCode >= 200 && $statusCode <= 300) {
            if (array_key_exists('OK', $body)) {
                $result->isOK = $body['OK'] > 0;
            }
        }
        if (!$result->isOK) {
            $result->errorCode = $statusCode;
            $result->errorMessage = $body['ErrList'][0]['cMess'] ?? $response->getStatusMessage();
        }
        return $result;
    }
}
