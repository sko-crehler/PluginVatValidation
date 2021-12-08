<?php declare(strict_types=1);

namespace Plugin\VatValidation\Controller;

use Plugin\VatValidation\Service\CheckVatService;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @RouteScope(scopes={"store-api"})
 */
class CheckVatController extends AbstractController
{
    private CheckVatService $checkVatService;

    public function __construct(CheckVatService $checkVatService)
    {
        $this->checkVatService = $checkVatService;
    }

    /**
     * @Route("/store-api/company/{vatId}", name="store-api.vat-validation", options={"seo"="false"}, methods={"GET"})
     */
    public function checkVat(string $vatId): JsonResponse
    {
        return new JsonResponse($this->checkVatService->fetchTraderData($vatId));
    }
}
