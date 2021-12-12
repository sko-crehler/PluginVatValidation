<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Controller;

use OpenApi\Annotations as OA;
use Plugin\VatValidation\Response\VatValidationResponse;
use Plugin\VatValidation\Service\CheckVatInterface;
use Plugin\VatValidation\Service\CheckVatServiceInterface;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @RouteScope(scopes={"store-api"})
 */
class CheckVatController extends AbstractController
{
    private CheckVatServiceInterface $checkVatService;

    public function __construct(CheckVatServiceInterface $checkVatService)
    {
        $this->checkVatService = $checkVatService;
    }

    /**
     * @OA\Get(
     *     path="/company/{vatId}",
     *     description="Loads the trader details of the given Company VAT ID",
     *     operationId="readCompanyData",
     *     tags={"Store API", "Company"},
     *     @OA\Parameter(
     *         parameter="vatId",
     *         name="vatId",
     *         in="path",
     *         description="VAT ID of the Company",
     *         @OA\Schema(type="string"),
     *         required=true
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Details of the Company Data",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="apiAlias",
     *                  type="string",
     *                  example="plugin_vat_validation_struct_trader_struct",
     *                  description="Api alias"
     *              ),
     *              @OA\Property(
     *                  property="traderName",
     *                  type="string",
     *                  example="COMPANY GmbH",
     *                  description="Company name"
     *              ),
     *              @OA\Property(
     *                  property="traderAddress",
     *                  type="string",
     *                  example="POZNAŃSKA 3D, 67-200 GŁOGÓW",
     *                  description="Company address"
     *              )
     *         )
     *     )
     * )
     * @Route("/store-api/company/{vatId}", name="store-api.vat-validation", options={"seo"="false"}, methods={"GET"})
     */
    public function checkVat(string $vatId): VatValidationResponse
    {
        return new VatValidationResponse($this->checkVatService->handleTraderData($vatId));
    }
}
