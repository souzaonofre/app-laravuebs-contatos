<?php

namespace App\Services;

use \GuzzleHttp\Client as HttpClient;

use App\Services\BaseService;

class CepService extends BaseService
{
    private object $httpClient;
    
    /**
     * Create a CepService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $baseApiUrl = 'https://cep.awesomeapi.com.br/';
        $reqOptions = [
            'base_uri'        => $baseApiUrl,
            'protocols'       => ['http', 'https'],
            'strict'          => false,
            'referer'         => false,
            'track_redirects' => false,
            'max'             => 5,
            'connect_timeout' => 5,
            'headers' => [
                'Accept'     => 'application/json'
            ]
        ];
        $this->httpClient = new HttpClient($reqOptions);
    }


    /**
     * Clean CEP string
     *
     * @return string
     */
    private function cepStrSanitizer(string $cep = '')
    {
        if (strlen($cep) >= 8) {
            return str_replace(['-','_','.',',',':','/','#'], '', $cep);
        } else {
            return '';
        }
    }

    /**
     * Get Address data by CEP value
     *
     * @return array
     */
    public function getAddressByCep(string $cep = '')
    {
        $cep = $this->cepStrSanitizer($cep);
        
        if (!$this->httpClient || !is_numeric($cep)) {
            return [];
        }
        
        $uri = sprintf('json/%s', $cep);
        $resp = $this->httpClient->request('GET', $uri);
        
        $status = $resp->getStatusCode();
        $contentLength = $resp->hasHeader('Content-Length');
        $contentType = $resp->hasHeader('Content-Type') ? $resp->getHeader('Content-Type')[0] : '';
        
        if ($status != 200 || !$contentLength || !stripos($contentType, 'json')) {
            return [];
        }
        
        $rawContent = $resp->getBody();
        
        if (!$rawContent) {
            return [];
        }
        
        return json_decode($rawContent, true);
    }
}
