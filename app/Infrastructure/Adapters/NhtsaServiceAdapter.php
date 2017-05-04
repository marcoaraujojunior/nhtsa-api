<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Contracts\ManufacturableInterface;
use App\Domain\Contracts\ManufacturableServiceAdapterInterface;

class NhtsaServiceAdapter implements ManufacturableServiceAdapterInterface
{
    /*
     * @param array $source
     * @param ManufacturableInterface $manufacturable
     * @return array ManufacturableInterface[]
     */
    public function toAdapter(Array $source, ManufacturableInterface $manufacturable)
    {
        $newSource = [];
        foreach ($source as $item) {
            $newSource[] = $manufacturable->newInstance()
                ->setDescription($item['VehicleDescription'])
                ->setModelYear($item['modelYear'])
                ->setManufacturer($item['manufacturer'])
                ->setModel($item['model'])
                ->setClassifiable($item['isClassifiable'])
                ->setRating($item['CrashRating'])
                ->setId($item['VehicleId']);
        }
        return $newSource;
    }
}

