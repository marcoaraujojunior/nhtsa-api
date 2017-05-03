<?php

namespace App\Infrastructure\Service;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

use App\Domain\Contracts\ManufacturableRecordInterface;
use App\Domain\Contracts\ManufacturableAttributesInterface;

class NhtsaService implements ManufacturableRecordInterface
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

    public function findByAttributes(ManufacturableAttributesInterface $parameters)
    {
        try {
            $response = $this->getClient()->request(
                'GET',
                $this->formatRouterParameters($parameters),
                $this->getQuery()
            );
        } catch (\Exception $e) {
            return [];
        }

        if (!$this->isValidResponse($response)){
            return [];
        }

        $body = json_decode($response->getBody(), true);
        $result = $this->formatResult($body, $parameters);
        if (!$parameters->isClassifiable()) {
            return $result;
        }

        return $this->addRating($result);
    }

    protected function catchRatingByVehicleId($id)
    {
        try {
            $response = $this->getClient()->request(
                'GET',
                'VehicleId/' . $id,
                $this->getQuery()
            );
        } catch (\Exception $e) {
            return '';
        }

        if (!$this->isValidResponse($response)){
            return '';
        }
        $body = json_decode($response->getBody(), true);

        return reset($body['Results'])['OverallRating'];
    }

    protected function addRating($result)
    {
        $newData = [];
        foreach ($result as $item) {
            $item['CrashRating'] = $this->catchRatingByVehicleId($item['VehicleId']);
            $newData[] = $item;
        }
        return $newData;
    }

    protected function isValidResponse($response)
    {
        if ($response->getStatusCode() != BaseResponse::HTTP_OK) {
            return false;
        }
        $body = json_decode($response->getBody(), true);
        return !empty($body['Results']);
    }

    protected function formatResult($body, ManufacturableAttributesInterface $parameters)
    {
        $result = [];
        $baseResult = [
            'modelYear' => $parameters->getModelYear(),
            'manufacturer' => $parameters->getManufacturer(),
            'model' => $parameters->getModel(),
            'isClassifiable' => $parameters->isClassifiable(),
            'CrashRating' => '',
        ];

        foreach ($body['Results'] as $itemKey => $item) {
            $result[] = array_merge($baseResult, $item);
        }

        return $result;
    }

    protected function formatRouterParameters(ManufacturableAttributesInterface $parameters)
    {
        return implode(
            '/',
            [
                'modelyear',
                $parameters->getModelYear(),
                'make',
                $parameters->getManufacturer(),
                'model',
                $parameters->getModel(),
            ]
        );
    }
}

