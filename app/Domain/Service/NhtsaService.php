<?php

namespace App\Domain\Service;

use GuzzleHttp\Client;
use App\Domain\Contracts\ManufacturedRecordInterface;
use App\Domain\Contracts\ManufacturedAttributesInterface;

class NhtsaService implements ManufacturedRecordInterface
{
    protected $client;
    protected $query = [
        'query' => ['format' => 'json']
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function findByAttributes(ManufacturedAttributesInterface $routeParameters)
    {
        try {
            $response = $this->getClient()->request(
                'GET',
                $this->formatRouterParameters($routeParameters),
                $this->getQuery()
            );
        } catch (\Exception $e) {
            return [];
        }

        if ($response->getStatusCode() != 200) {
            return [];
        }

        return $this->formatResult($response);
    }

    protected function formatResult($response)
    {
        $result = json_decode($response->getBody(), true);
        return $result['Results'];
    }

    protected function formatRouterParameters(ManufacturedAttributesInterface $routeParameters)
    {
        return implode(
            '/',
            [
                'modelyear',
                $routeParameters->getModelYear(),
                'make',
                $routeParameters->getManufacturer(),
                'model',
                $routeParameters->getModel(),
            ]
        );
    }
}
