<?php declare(strict_types=1);

namespace SwagExample\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use SwagExample\Service\GovApiService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @RouteScope(scopes={"store-api"})
 */
class GovApiController extends AbstractController
{
    private GovApiService $govApiService;

    public function __construct(GovApiService $govApiService)
    {
        $this->govApiService = $govApiService;
    }

    //todo: add swagger
    /**
     * @Route("/store-api/govapi/vat/{vatId}", name="store-api.govapi.vat", options={"seo"="false"}, methods={"GET"})
     */
    public function calculate(string $vatId): JsonResponse
    {
        $response = $this->govApiService->getData($vatId);
        return new JsonResponse($response);
    }
}
