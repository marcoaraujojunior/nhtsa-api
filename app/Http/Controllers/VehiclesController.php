<?php

namespace App\Http\Controllers;

use App\Domain\Model\Vehicle\Vehicle;

class VehiclesController extends Controller
{

    protected $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

     /**
     * Display a listing of the vehicles by Model Year, Manufacturer and Model.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/vehicles/{year}/{manufacturer}/{model}",
     *     description="Returns list of vehicles",
     *     operationId="vehicles.allByAttributes",
     *     produces={"application/json"},
     *     tags={"vehicles"},
     *     @SWG\Parameter(
     *         name="{year}",
     *         in="path",
     *         description="The model year of vehicle",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="{manufacturer}",
     *         in="path",
     *         description="The manufacturer of vehicle",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="{model}",
     *         in="path",
     *         description="The model of vehicle",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="List of vehicles"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     )
     * )
     */
    public function allByAttributes($modelYear, $manufacturer, $model)
    {
        $result = $this->vehicle
            ->setModelYear($modelYear)
            ->setManufacturer($manufacturer)
            ->setModel($model)
            ->findAll();

        return response()->json([
            'Counts' => count($result),
            'Results' => $result,
        ]);
    }
}

