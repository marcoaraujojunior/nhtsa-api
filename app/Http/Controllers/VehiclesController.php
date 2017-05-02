<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use Laravel\Lumen\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

use App\Domain\Contracts\ManufacturedRepositoryInterface as Repository;
use App\Domain\Contracts\ManufacturedAttributesInterface as Manufactured;

class VehiclesController extends Controller
{

    protected $vehicle;
    protected $repository;
    protected $response;

    public function __construct(Manufactured $vehicle, Repository $repository, ResponseFactory $response)
    {
        $this->vehicle = $vehicle;
        $this->repository = $repository;
        $this->response = $response;
    }

    /**
     * Display a listing of the vehicles by Model Year, Manufacturer and Model.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/vehicles/{year}/{manufacturer}/{model}",
     *     description="Returns list of vehicles",
     *     operationId="vehicles.findAllByAttributes",
     *     produces={"application/json"},
     *     tags={"vehicles"},
     *     @SWG\Parameter(
     *         name="year",
     *         in="path",
     *         description="The model year of vehicle",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         description="The manufacturer of vehicle",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="model",
     *         in="path",
     *         description="The model of vehicle",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="withRating",
     *         in="query",
     *         description="Determines whether show crash rating",
     *         required=false,
     *         default=false,
     *         type="boolean"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="List of vehicles",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="Counts",
     *                 type="integer",
     *                 example=1,
     *                 description="Total results"
     *             ),
     *             @SWG\Property(
     *                 property="Results",
     *                 type="array",
     *                 @SWG\Items(
     *                     type="object",
     *                     @SWG\Property(
     *                         property="Description",
     *                         description="Description of vehicle",
     *                         type="string",
     *                         example="2015 Audi A3 C FWD"
     *                     ),
     *                     @SWG\Property(
     *                         property="VehicleId",
     *                         description="Id of vehicle",
     *                         type="integer",
     *                         example=9406
     *                     ),
     *                     @SWG\Property(
     *                         description="Crash Rating of vehicle (is shown when withRating is true)",
     *                         property="CrashRating",
     *                         type="string",
     *                         example="Not Rated",
     *                     ),
     *                 )
     *             ),
     *         )
     *     )
     * )
     */
    public function findAllByAttributes($modelYear, $manufacturer, $model, Request $request)
    {
        $withRating = filter_var($request->get('withRating'), FILTER_VALIDATE_BOOLEAN);
        return $this->doResponse($modelYear, $manufacturer, $model, $withRating);
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
        $modelYear = $request->json()->get('modelYear');
        $manufacturer = $request->json()->get('manufacturer');
        $model = $request->json()->get('model');

        return $this->doResponse($modelYear, $manufacturer, $model, false, BaseResponse::HTTP_CREATED);
    }

    protected function doResponse($modelYear, $manufacturer, $model, $withRating, $httpStatusCode = BaseResponse::HTTP_OK)
    {
        $vehicle = $this->vehicle->newInstance($modelYear, $manufacturer, $model, $withRating);
        $result = $this->repository->findAll($vehicle);

        $data = [ 'Counts' => count($result), 'Results' => $result ];
        return $this->response->json($data, $httpStatusCode);
    }
}

