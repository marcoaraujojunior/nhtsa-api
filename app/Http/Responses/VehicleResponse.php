<?php

namespace App\Http\Responses;

class VehicleResponse
{
    public function format(Array $vehicles)
    {
        $formatted = [];
        foreach ($vehicles as $vehicle) {
            $item = [
                'Description' => $vehicle->getDescription(),
                'VehicleId' => $vehicle->getId(),
            ];
            if ($vehicle->isClassifiable()) {
                $item['CrashRating'] = $vehicle->getRating();
            }
            $formatted[] = $item;
        }
        return  [
            'Counts' => count($formatted),
            'Results' => $formatted,
        ];
    }
}
