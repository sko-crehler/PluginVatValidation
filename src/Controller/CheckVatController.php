<?php declare(strict_types=1);

namespace SwagExample\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use SwagExample\Service\CheckVatService;
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
     * @Route("/store-api/company/{vatId}", name="store-api.check-vat", options={"seo"="false"}, methods={"GET"})
     */
    public function checkVat(string $vatId): JsonResponse
    {
        $response = $this->checkVatService->fetchTraderData($vatId);

        return new JsonResponse($response);
    }
}
