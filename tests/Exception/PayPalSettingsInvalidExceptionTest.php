<?php declare(strict_types=1);

namespace Plugin\VatValidation\Test\Exception;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Exception\CompanyNoInformationException;
use Symfony\Component\HttpFoundation\Response;

class CompanyNoInformationExceptionTest extends TestCase
{
    public function testGetStatusCode(): void
    {
        $settingOption = 'Company no information.';
        $exception = new CompanyNoInformationException($settingOption);

        static::assertSame(\sprintf($settingOption), $exception->getMessage());
        static::assertSame(Response::HTTP_BAD_REQUEST, $exception->getStatusCode());
    }
}
