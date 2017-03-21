<?php

namespace DaliAPI;

use Aws\DynamoDb\DynamoDbClient;
use DaliAPI\Request\LambdaRequest;
use DaliAPI\Response\JSONResponse;
use DaliAPI\Response\ResponseArray;
use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Mvc\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function registerAutoloaders()
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'DaliAPI\Controllers' => '../apps/controllers/',
                'DaliAPI\Models'      => '../apps/models/',
                'DaliAPI\Library'     => '../apps/library/',
                'DaliAPI\Request'     => '../apps/request/',
                'DaliAPI\Response'    => '../apps/response/'
            ]
        );

		$loader->registerFiles(
			[
				'../../vendor/autoload.php',
			]
		);

        $loader->register();
    }

    /**
     * This methods registers the services to be used by the application
     */
    protected function registerServices()
    {
        $di = new DI();

        /**
         * Get routes
         */
        require_once '../config/routes.php';

        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('DaliAPI\Controllers\\');
            return $dispatcher;
        });

        // Registering a Http\Response
        $di->set('response', function () {
            return new Response();
        });

        // Registering a Http\Request
        $di->set('request', function () {
            return new LambdaRequest();
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->disable();
            return $view;
        });

		/**
		 * Services can be registered as "shared" services this means that they always will act as singletons. Once the service is resolved for the first time the same instance of it is returned every time a consumer retrieve the service from the container:
		 */
		$di->setShared(
			"dynamoDBClient",
			function () {
				return new DynamoDbClient([
					'version'  => 'latest',
					'region'   => getenv('AWS_REGION')
				]);
			}
		);

        $this->setDI($di);



    }

    public function run()
    {

        $this->registerServices();
        $this->registerAutoloaders();

        // Handle request
        $this->handle();

        // Get the returned value by the last executed action
        $controllerResponse = $this->dispatcher->getReturnedValue();

        if (is_a($controllerResponse, 'DaliAPI\Response\ResponseArray')) {

            /** @var $controllerResponse ResponseArray */
            $controllerResponse->setCount($controllerResponse->getCount());
        }

        /** @var LambdaRequest $request */
        $request = $this->getDI()->get('request');

        if ( $request->isJSON() ) {

            $json = new JSONResponse($controllerResponse);
            return $json->send();

        }
    }
}

try {

	/**
	 * Create MVC application
	 */
    $application = new Application();

	/**
	 * Run app
	 */
    $application->run();

} catch (\Exception $e) {
    echo $e->getMessage();
}
