<?php

namespace App\Test;

use \Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

use App\Domain\Service\NhtsaService;
use App\Domain\Model\Vehicle\Vehicle;
use App\Domain\Contracts\ManufacturedAttributesInterface;
use App\Domain\Contracts\ManufacturedRecordInterface;

class VehicleTest extends \TestCase
{
    public function testFindAllShouldReturnSuccessfulResults()
    {

        $bodyResponse = '{"Count":2,"Message":"Results returned successfully","Results":[{"VehicleDescription":"2015 Audi A3 4 DR AWD","VehicleId":9403},{"VehicleDescription":"2015 Audi A3 4 DR FWD","VehicleId":9408}]}';

        $record = $this->mockManufacturedRecord($bodyResponse);

        $vehicle = (new Vehicle($record))
            ->setModelYear('2015')
            ->setManufacturer('Audi')
            ->setWithRating(false)
            ->setModel('A3');

        $expected = [
            [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
            [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
        ];
        $this->assertEquals(
            $expected, $vehicle->findAll()
        );
    }

    protected function mockManufacturedRecord($bodyResponse = '')
    {
        $mock = new MockHandler([
            new Response(BaseResponse::HTTP_OK, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new NhtsaService($client);
    }
}

