<?php

namespace App\Http\Controllers;

use App\Domain\Model\Vehicle\Vehicle;
use \Illuminate\Http\Request;

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
     *         description="List of vehicles",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="count",
     *                 type="integer",
     *             ),
     *             @SWG\Property(
     *                 property="Results",
     *                 type="array",
     *                 @SWG\Items(
     *                     type="object",
     *                     @SWG\Property(
     *                         property="Description",
     *                         type="string",
     *                     ),
     *                     @SWG\Property(
     *                         property="VehicleId",
     *                         type="integer",
     *                     ),
     *                 )
     *             ),
     *         )
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

    /**
     * @SWG\Post(path="/vehicles",
     *   tags={"vehicle"},
     *   summary="Create vehicle",
     *   description="Create a vehicle record",
     *   operationId="create",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created vehicle object",
     *     required=true,
     *     @SWG\Schema(
     *       type="object",
     *       @SWG\Property(
     *          property="modelYear",
     *          type="integer",
     *       ),
     *       @SWG\Property(
     *          property="manufacturer",
     *          type="string",
     *       ),
     *       @SWG\Property(
     *          property="model",
     *          type="string",
     *       ),
     *     )
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    public function create(Request $request)
    {
        $data = $request->json()->all();
        $modelYear = $request->json()->get('modelYear');
        $manufacturer = $request->json()->get('manufacturer');
        $model = $request->json()->get('model');

        return $this->allByAttributes($modelYear, $manufacturer, $model);
    }
}

