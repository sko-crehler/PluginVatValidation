<?php

namespace Plugin\VatValidation\Util;

use GuzzleHttp\Client;
use SoapClient;

class TimeoutSoapClient extends SoapClient
{
    private const TIMEOUT = 5;

    public function __doRequest($request, $location, $action, $version, bool $oneWay = false): string
    {
        $client = new Client();
        return (string) $client->post($location, [
            'body' => $request,
            'headers' => [
                'SOAPAction' => $action
            ],
            'timeout' => self::TIMEOUT,
            'connect_timeout' => self::TIMEOUT
        ])->getBody();
    }
}