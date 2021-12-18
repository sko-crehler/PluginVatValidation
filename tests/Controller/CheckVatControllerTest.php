<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Controller;

use Shopware\Core\Framework\Context;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\SalesChannelApiTestBehaviour;
use Shopware\Core\Framework\Test\TestDataCollection;
use Symfony\Component\HttpFoundation\Response;

class CheckVatControllerTest extends TestCase
{
    use IntegrationTestBehaviour;
    use SalesChannelApiTestBehaviour;

    private MockObject $checkVatService;

    protected function setUp(): void
    {
        $this->ids = new TestDataCollection(Context::createDefaultContext());
        
        $this->browser = $this->createCustomSalesChannelBrowser([
            'id' => $this->ids->create('sales-channel'),
        ]);
    }

    public function testRequestVatIdNotValid(): void
    {
        $this->browser
            ->request(
                'GET',
                '/store-api/company/' . Uuid::randomHex(),
            );

        static::assertIsString($this->browser->getResponse()->getContent());
        $response = json_decode($this->browser->getResponse()->getContent(), true);

        static::assertArrayHasKey('errors', $response);
        static::assertSame('CONNECT_ERROR', $response['errors'][0]['code']);
    }

    public function testRequestVatIValid(): void
    {
        $this->browser
            ->request(
                'GET',
                '/store-api/company/' . 'PL5252546391',
            );

        static::assertIsString($this->browser->getResponse()->getContent());
        $response = json_decode($this->browser->getResponse()->getContent(), true);

        static::assertSame(Response::HTTP_OK, $this->browser->getResponse()->getStatusCode());
        static::assertSame('AMAZON FULFILLMENT POLAND SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ', $response['traderName']);
        static::assertSame("POZNAŃSKA 1D\n62-080 SADY", $response['traderAddress']);
        static::assertSame('plugin_vat_validation_struct_trader_struct', $response['apiAlias']);
    
    }
}
