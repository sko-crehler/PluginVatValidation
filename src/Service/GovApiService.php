<?php declare(strict_types=1);

namespace SwagExample\Service;

use GuzzleHttp\Client;

class GovApiService
{
    private const GOV_URL = 'https://wl-api.mf.gov.pl/api/search/nip/';

    public function getData(string $vatId)
    {
        $restClient = new Client();

        $response = $restClient->request('GET', self::GOV_URL . $vatId . '?date=' . '2021-12-04');

        if (!$response || $response->getStatusCode() !== 200) {
            return null;
        }

        $responseBody = json_decode((string) $response->getBody(), true);

        return $responseBody;
    }
}
