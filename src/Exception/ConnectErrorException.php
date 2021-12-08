<?php declare(strict_types=1);

namespace Plugin\VatValidation\Exception;

use Shopware\Core\Framework\ShopwareHttpException;
use Symfony\Component\HttpFoundation\Response;

class ConnectErrorException extends ShopwareHttpException
{
    public function __construct(string $missingSetting)
    {
        parent::__construct(
            'Connect Error: "{{ missingSetting }}"',
            ['missingSetting' => $missingSetting]
        );
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function getErrorCode(): string
    {
        return 'CONNECT_ERROR';
    }
}
