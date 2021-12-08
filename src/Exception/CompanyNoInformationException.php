<?php declare(strict_types=1);

namespace Plugin\VatValidation\Exception;

use Shopware\Core\Framework\ShopwareHttpException;
use Symfony\Component\HttpFoundation\Response;

class CompanyNoInformationException extends ShopwareHttpException
{
    public function __construct()
    {
        $message = "Company no information.";

        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getErrorCode(): string
    {
        return 'COMPANY_NO_INFORMATION';
    }
}
