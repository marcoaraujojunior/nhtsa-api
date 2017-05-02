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
use App\Domain\Contracts\ManufacturedRequestedAttributesInterface;

class NhsaServiceTest extends \TestCase
{
    public function testFindByAttributesShouldReturnValidArrayWithoutRatingWhenSuccessfulRequestAndWithRatingIsFalse()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, [], $this->successfulResult()),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(false)->mock();

        $expected = [
            [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
            [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
            [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405 ],
            [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406 ],
        ];

        $this->assertEquals(
            $expected, $service->findByAttributes($vehicle)
        );
    }

    public function testFindByAttributesShouldReturnValidArrayWithRatingWhenSuccessfulRequestAndWithRatingIsTrue()
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

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(true)->mock();

        $expected = [
            [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403, 'CrashRating' => '5' ],
            [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408, 'CrashRating' => '5' ],
            [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405, 'CrashRating' => 'Not Rated' ],
            [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406, 'CrashRating' => 'Not Rated' ],
        ];

        $this->assertEquals(
            $expected, $service->findByAttributes($vehicle)
        );
    }

    public function testFindByAttributesShouldReturnValidArrayWithEmptyRatingWhenEmptyResponseFromRatingAndWithRatingIsTrue()
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

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(true)->mock();

        $expected = [
            [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403, 'CrashRating' => '' ],
            [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408, 'CrashRating' => '' ],
            [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405, 'CrashRating' => '' ],
            [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406, 'CrashRating' => '' ],
        ];

        $this->assertEquals(
            $expected, $service->findByAttributes($vehicle)
        );
    }

    public function testFindByAttributesShouldReturnValidArrayWithEmptyRatingWhenRequestToRatingFailAndWithRatingIsTrue()
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

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(true)->mock();

        $expected = [
            [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403, 'CrashRating' => '' ],
            [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408, 'CrashRating' => '' ],
            [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405, 'CrashRating' => '' ],
            [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406, 'CrashRating' => '' ],
        ];

        $this->assertEquals(
            $expected, $service->findByAttributes($vehicle)
        );
    }

    public function testFindByAttributesShouldReturnEmptyArrayWhenRequestException()
    {
        $mock = new MockHandler([
            new RequestException("Error Communicating with Server", new Request('GET', 'test')),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(false)->mock();

        $this->assertEquals(
            [], $service->findByAttributes($vehicle)
        );
    }

    public function testFindByAttributesShouldReturnEmptyArrayWhenResponseStatusCodeIsNotTwoHundred()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_NO_CONTENT, []),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(false)->mock();

        $this->assertEquals(
            [], $service->findByAttributes($vehicle)
        );
    }

    public function testFindByAttributesShouldReturnEmptyArrayWhenEmptyResults()
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, []),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $service = new NhtsaService($client);

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');
        $vehicle->shouldReceive('getModelYear')->andReturn(2015)->mock();
        $vehicle->shouldReceive('getManufacturer')->andReturn('Audi')->mock();
        $vehicle->shouldReceive('getModel')->andReturn('A3')->mock();
        $vehicle->shouldReceive('withRating')->andReturn(false)->mock();

        $this->assertEquals(
            [], $service->findByAttributes($vehicle)
        );
    }

    protected function successfulResult()
    {
        return '{"Count":4,"Message":"Results returned successfully","Results":[{"VehicleDescription":"2015 Audi A3 4 DR AWD","VehicleId":9403},{"VehicleDescription":"2015 Audi A3 4 DR FWD","VehicleId":9408},{"VehicleDescription":"2015 Audi A3 C AWD","VehicleId":9405},{"VehicleDescription":"2015 Audi A3 C FWD","VehicleId":9406}]}';
    }

}

