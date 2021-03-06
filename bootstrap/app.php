<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
 * Because swagger use constatnt
 */

defined('API_HOST') or define('API_HOST', env('API_HOST'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();

// $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);


$app->singleton(
    GuzzleHttp\Client::class,
    function ($app) {

        $stack = GuzzleHttp\HandlerStack::create();
        $stack->push(
            GuzzleHttp\Middleware::log(
                with(new \Monolog\Logger('api-consumer'))->pushHandler(
                    new \Monolog\Handler\RotatingFileHandler(storage_path('logs/api-consumer.log'))
                ),
                new GuzzleHttp\MessageFormatter(
                    '{method} {uri} HTTP/{version} {req_body} RESPONSE: {code}'
                )
            )
        );

        return new GuzzleHttp\Client([
            'base_uri' => env('RESOURCE_BASE_URI', null),
            'handler' => $stack,
        ]);
    }
);

$app->bind(
    App\Domain\Contracts\ManufacturableRecordInterface::class,
    App\Infrastructure\Service\NhtsaService::class
);

$app->bind(
    App\Domain\Contracts\ManufacturableAttributesInterface::class,
    App\Http\Requests\VehicleRequest::class
);

$app->bind(
    App\Domain\Contracts\ManufacturableRepositoryInterface::class,
    App\Domain\Repositories\VehicleRepository::class
);

$app->bind(
    App\Domain\Contracts\ManufacturableServiceAdapterInterface::class,
    App\Infrastructure\Adapters\NhtsaServiceAdapter::class
);

$app->bind(
    App\Domain\Contracts\ManufacturableInterface::class,
    App\Domain\Entities\VehicleEntity::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

(new App\Http\Routes\Api($app))
    ->setOptions(['namespace' => 'App\Http\Controllers'])
    ->register();

return $app;
