<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Exception;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Exception\CompanyNotValidException;
use Symfony\Component\HttpFoundation\Response;

class CompanyNotValidExceptionTest extends TestCase
{
    public function testGetStatusCode(): void
    {
        $message = "Company is not valid.";
        $exception = new CompanyNotValidException();

        static::assertSame(\sprintf($message), $exception->getMessage());
        static::assertSame(Response::HTTP_BAD_REQUEST, $exception->getStatusCode());
    }
}
