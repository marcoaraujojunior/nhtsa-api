<?php

namespace App\Test\Controller;

use \Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Domain\Service\NhtsaService;
use App\Domain\Contracts\ManufacturableAttributesInterface;
use App\Domain\Contracts\ManufacturableRecordInterface;

class VehicleControllerTest extends \TestCase
{

    public function testFindAllByAttributesShouldReturnCountAndResults()
    {
        $this->get('/vehicles/2015/Audi/A3');

        $expected = [
            'Counts' => 4,
            'Results' => [
                [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
                [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
                [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405 ],
                [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406 ],
            ]
        ];

        $this->assertEquals(
            $expected, json_decode($this->response->getContent(), true)
        );
    }

    public function testFindAllByAttributesShouldReturnCountAndResultsWithRating()
    {
        $this->get('/vehicles/2015/Audi/A3?withRating=true');

        $expected = [
            'Counts' => 4,
            'Results' => [
                [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403, 'CrashRating' => '5' ],
                [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408, 'CrashRating' => '5' ],
                [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405, 'CrashRating' => 'Not Rated' ],
                [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406, 'CrashRating' => 'Not Rated' ],
            ]
        ];

        $this->assertEquals(
            $expected, json_decode($this->response->getContent(), true)
        );
    }

    public function testCreateShouldFakeSaveAndReturnFindAllByAttributesResults()
    {

        $expected = [
            'Counts' => 4,
            'Results' => [
                [ 'Description' => '2015 Audi A3 4 DR AWD', 'VehicleId' => 9403 ],
                [ 'Description' => '2015 Audi A3 4 DR FWD', 'VehicleId' => 9408 ],
                [ 'Description' => '2015 Audi A3 C AWD', 'VehicleId' => 9405 ],
                [ 'Description' => '2015 Audi A3 C FWD', 'VehicleId' => 9406 ],
            ]
        ];

        $this->json('POST', '/vehicles', ['modelYear' => '2015', 'manufacturer' => 'Audi', 'model' => 'A3'])
            ->seeJsonEquals($expected)
            ->assertResponseStatus(201);
    }

    public function testCreateShouldReturnBadRequestWhenInvalidInput()
    {

        $expected = [
            'Counts' => 0,
            'Results' => []
        ];

        $this->json('POST', '/vehicles', ['manufacturer' => 'Honda', 'model' => 'Accord'])
            ->seeJsonEquals($expected)
            ->assertResponseStatus(400);
    }
}

