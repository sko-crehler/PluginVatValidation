<?php declare(strict_types=1);

namespace SwagExample\Service;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use SoapClient;
use SoapFault;

class GovApiService
{
    private const GOV_URL = 'https://wl-api.mf.gov.pl/api/search/nip/';

    private Client $restClient;

    public function __construct()
    {
        $this->restClient = new Client();
    }

    public static function validateVATID($requestedVatId, $company = null, $city = null)
    {
        $ret = false;
        $ecUrl = "http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl";
        $vatid = str_replace(array(' ', '.', '-', ',', ', '), '', trim($requestedVatId));
        $cc = substr($vatid, 0, 2);
        $vn = substr($vatid, 2);
        $client = new SoapClient($ecUrl);

        if ($client) {
            $params = array('countryCode' => $cc,
                'vatNumber' => $vn,
            );

            try {
//                $r = $client->checkVatApprox($params);
                $r = $client->checkVat($params);

                if ($r->valid == true) {

                    return [
                        'traderName' => $r->name,
                        'traderAddress' => $r->address
                    ];
                } else {
                    return $ret;
                }
            } catch (SoapFault $e) {
                $ret = $e->faultstring;
            }
        } else {
            $ret = 'CONNECTERROR';
        }

        return $ret;
    }
}
