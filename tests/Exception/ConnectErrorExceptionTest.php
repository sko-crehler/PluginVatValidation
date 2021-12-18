<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Exception;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Exception\ConnectErrorException;
use Symfony\Component\HttpFoundation\Response;

class ConnectErrorExceptionTest extends TestCase
{
    public function testGetStatusCode(): void
    {
        $message = "Error";
        $exception = new ConnectErrorException($message);

        static::assertSame(\sprintf('Connect Error: "' . $message . '"'), $exception->getMessage());
        static::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getStatusCode());
    }
}
