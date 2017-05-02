<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host=API_HOST,
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="NHTSA API",
 *         @SWG\Contact(name="Marco Araujo", url="http://www.marcojunior.com"),
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
class Controller extends BaseController
{
    //
}
