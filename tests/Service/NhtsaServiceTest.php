<?php

namespace App\Test\Service;

use \Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

use App\Infrastructure\Service\NhtsaService;
use App\Domain\Contracts\ManufacturableAttributesInterface;

class NhtsaServiceTest extends \TestCase
{
    public function testFindAllShouldReturnValidArrayWithoutRatingWhenSuccessfulRequestAndWithRatingIsFalse()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, [], $this->successfulResult()),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(false)->mock();

        $baseExpected = [
            'modelYear' => 2015,
            'manufacturer' => 'Audi',
            'model' => 'A3',
            'isClassifiable' => false,
            'CrashRating' => '',
        ];
        $expected = [
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C AWD', 'VehicleId' => 9405 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C FWD', 'VehicleId' => 9406 ],
        ];

        $this->assertEquals(
            $expected, $service->findAll($vehicle)
        );
    }

    public function testFindAllShouldReturnValidArrayWithRatingWhenSuccessfulRequestAndWithRatingIsTrue()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, [], $this->successfulResult()),
            new Response(BaseResponse::HTTP_OK, [], '{"Count":1,"Message":"Results returned successfully","Results":[{"OverallRating":"5"}]}'),
            new Response(BaseResponse::HTTP_OK, [], '{"Count":1,"Message":"Results returned successfully","Results":[{"OverallRating":"5"}]}'),
            new Response(BaseResponse::HTTP_OK, [], '{"Count":1,"Message":"Results returned successfully","Results":[{"OverallRating":"Not Rated"}]}'),
            new Response(BaseResponse::HTTP_OK, [], '{"Count":1,"Message":"Results returned successfully","Results":[{"OverallRating":"Not Rated"}]}'),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(true)->mock();

        $baseExpected = [
            'modelYear' => 2015,
            'manufacturer' => 'Audi',
            'model' => 'A3',
            'isClassifiable' => true,
        ];

        $expected = [
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403, 'CrashRating' => '5' ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408, 'CrashRating' => '5' ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C AWD', 'VehicleId' => 9405, 'CrashRating' => 'Not Rated' ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C FWD', 'VehicleId' => 9406, 'CrashRating' => 'Not Rated' ],
        ];

        $this->assertEquals(
            $expected, $service->findAll($vehicle)
        );
    }

    public function testFindAllShouldReturnValidArrayWithEmptyRatingWhenEmptyResponseFromRatingAndWithRatingIsTrue()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, [], $this->successfulResult()),
            new Response(BaseResponse::HTTP_OK, [], ''),
            new Response(BaseResponse::HTTP_OK, [], ''),
            new Response(BaseResponse::HTTP_OK, [], ''),
            new Response(BaseResponse::HTTP_OK, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(true)->mock();

        $baseExpected = [
            'modelYear' => 2015,
            'manufacturer' => 'Audi',
            'model' => 'A3',
            'isClassifiable' => true,
            'CrashRating' => '',
        ];
        $expected = [
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C AWD', 'VehicleId' => 9405 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C FWD', 'VehicleId' => 9406 ],
        ];

        $this->assertEquals(
            $expected, $service->findAll($vehicle)
        );
    }

    public function testFindAllShouldReturnValidArrayWithEmptyRatingWhenRequestToRatingFailAndWithRatingIsTrue()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, [], $this->successfulResult()),
            new Response(BaseResponse::HTTP_SERVICE_UNAVAILABLE, [], ''),
            new Response(BaseResponse::HTTP_SERVICE_UNAVAILABLE, [], ''),
            new Response(BaseResponse::HTTP_SERVICE_UNAVAILABLE, [], ''),
            new Response(BaseResponse::HTTP_SERVICE_UNAVAILABLE, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(true)->mock();

        $baseExpected = [
            'modelYear' => 2015,
            'manufacturer' => 'Audi',
            'model' => 'A3',
            'isClassifiable' => true,
            'CrashRating' => '',
        ];
        $expected = [
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C AWD', 'VehicleId' => 9405 ],
            $baseExpected + [ 'VehicleDescription' => '2015 Audi A3 C FWD', 'VehicleId' => 9406 ],
        ];

        $this->assertEquals(
            $expected, $service->findAll($vehicle)
        );
    }

    public function testFindAllShouldReturnEmptyArrayWhenRequestException()
    {
        $mock = new MockHandler([
            new RequestException("Error Communicating with Server", new Request('GET', 'test')),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(false)->mock();

        $this->assertEquals(
            [], $service->findAll($vehicle)
        );
    }

    public function testFindAllShouldReturnEmptyArrayWhenResponseStatusCodeIsNotTwoHundred()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_NO_CONTENT, []),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(false)->mock();

        $this->assertEquals(
            [], $service->findAll($vehicle)
        );
    }

    public function testFindAllShouldReturnEmptyArrayWhenEmptyResults()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, []),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('isClassifiable')->andReturn(false)->mock();

        $this->assertEquals(
            [], $service->findAll($vehicle)
        );
    }

    protected function successfulResult()
    {
        return json_encode([
            'Count' => 4,
            'Message' => 'Results returned successfully',
            'Results' => [
                [
                    'VehicleDescription' => '2015 Audi A3 4 DR AWD',
                    'VehicleId' => 9403,
                ],
                [
                    'VehicleDescription' => '2015 Audi A3 4 DR FWD',
                    'VehicleId' => 9408,
                ],
                [
                    'VehicleDescription' => '2015 Audi A3 C AWD',
                    'VehicleId' => 9405,
                ],
                [
                    'VehicleDescription' => '2015 Audi A3 C FWD',
                    'VehicleId' => 9406,
                ],
            ]
        ]);
    }
}

