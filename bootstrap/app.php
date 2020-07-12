<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

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

$app->withEloquent();

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
//General
$app->middleware([
    //Que la petición sea con Headers Content-Type:application/json
    // App\Http\Middleware\PetitionMiddleware::class,
    App\Http\Middleware\CorsMiddleware::class,
    // App\Http\Middleware\YearMiddleware::class,
    
]);
//Rutas específicas
$app->routeMiddleware([
    //Middleware que ocupan autenticación de api_token
    'auth' => App\Http\Middleware\Authenticate::class,
    //Middleware para roll Secretary
    'secre' => App\Http\Middleware\SecretaryMiddleware::class,
    'manager' => App\Http\Middleware\ManagerMiddleware::class,
    'admin' => App\Http\Middleware\AdminerMiddleware::class,
    'manager-secre' => App\Http\Middleware\ManagerSecretaryMiddleware::class,
    'apikey' => App\Http\Middleware\ApikeyMiddleware::class,
    'officeauth' => App\Http\Middleware\OfficeMiddleware::class,
    'year' => App\Http\Middleware\YearMiddleware::class,
    'json' => App\Http\Middleware\PetitionMiddleware::class,
    //Middleware para un roll específico 2
    //Middleware para un roll específico 3 
]);

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

$app->register(BC\Laravel\DropboxDriver\ServiceProvider::class);
// $app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class); //MAIL
// $app->configure('mail');
// $app->alias('mailer', Illuminate\Mail\Mailer::class);
// $app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
// $app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);
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

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
