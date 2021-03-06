<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use Laravel\Lumen\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

use App\Domain\Contracts\ManufacturableRepositoryInterface as Repository;
use App\Domain\Contracts\ManufacturableAttributesInterface as Manufacturable;
use App\Http\Responses\VehicleResponse;

class VehiclesController extends Controller
{

    protected $vehicle;
    protected $repository;
    protected $response;
    protected $vehicleResponse;

    public function __construct(
        Manufacturable $vehicle,
        Repository $repository,
        ResponseFactory $response,
        VehicleResponse $vehicleResponse
    )
    {
        $this->vehicle = $vehicle;
        $this->repository = $repository;
        $this->response = $response;
        $this->vehicleResponse = $vehicleResponse;
    }

    /**
     * Display a listing of the vehicles by Model Year, Manufacturer and Model.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/vehicles/{year}/{manufacturer}/{model}",
     *     description="Returns list of vehicles",
     *     operationId="vehicles.findAll",
     *     produces={"application/json"},
     *     tags={"vehicles"},
     *     @SWG\Parameter(
     *         name="year",
     *         in="path",
     *         description="The model year of vehicle",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         description="The manufacturer of vehicle",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="model",
     *         in="path",
     *         description="The model of vehicle",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="withRating",
     *         in="query",
     *         description="Determines whether show crash rating",
     *         required=false,
     *         default=false,
     *         type="boolean",
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
    public function findAll($modelYear, $manufacturer, $model, Request $request)
    {
        $isClassifiable = filter_var($request->get('withRating'), FILTER_VALIDATE_BOOLEAN);
        $data = $this->doResponse($modelYear, $manufacturer, $model, $isClassifiable);
        return $this->response->json($data, BaseResponse::HTTP_OK);
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
     *          example=2017,
     *       ),
     *       @SWG\Property(
     *          property="manufacturer",
     *          type="string",
     *          example="volkswagen",
     *       ),
     *       @SWG\Property(
     *          property="model",
     *          type="string",
     *          example="golf",
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

        $httpStatusCode = BaseResponse::HTTP_CREATED;
        $data = $this->doResponse($modelYear, $manufacturer, $model, false);
        if (empty($data['Results'])) {
            $httpStatusCode = BaseResponse::HTTP_BAD_REQUEST;
        }
        return $this->response->json($data, $httpStatusCode);
    }

    protected function doResponse($modelYear, $manufacturer, $model, $isClassifiable)
    {
        $this->vehicle
            ->setModelYear($modelYear)
            ->setManufacturer($manufacturer)
            ->setModel($model)
            ->setClassifiable($isClassifiable);

        $result = $this->repository->findAll($this->vehicle);
        return $this->vehicleResponse->format($result);
    }
}

