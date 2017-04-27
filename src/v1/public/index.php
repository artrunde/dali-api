<?php

namespace RodinAPI;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use RodinAPI\Exceptions\HandledException;
use RodinAPI\Exceptions\InternalErrorException;
use RodinAPI\Request\LambdaRequest;
use RodinAPI\Response\JSONResponse;
use RodinAPI\Response\ResponseArray;
use RodinAPI\Response\ResponseMessage;
use Phalcon\DI;
use Phalcon\Http\Response;
use RodinAPI\Response\Response as HTTPResponse;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function registerAutoloaders()
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'RodinAPI\Controllers' => '../apps/controllers/',
                'RodinAPI\Models'      => '../apps/models/',
                'RodinAPI\Library'     => '../apps/library/',
                'RodinAPI\Request'     => '../apps/request/',
                'RodinAPI\Response'    => '../apps/response/',
                'RodinAPI\Exceptions'  => '../apps/exceptions/',
                'RodinAPI\Validators'  => '../apps/validators/',
                'RodinAPI\Factories'   => '../apps/factories/'
            ]
        );

		$loader->registerFiles(
			[
				'../../../vendor/autoload.php',
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
            $dispatcher->setDefaultNamespace('RodinAPI\Controllers\\');
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

        $di->setShared(
            "dynamoDBMarshaler",
            function () {
                return new Marshaler();
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

        if (is_a($controllerResponse, 'RodinAPI\Response\ResponseArray')) {

            /** @var $controllerResponse ResponseArray */
            $controllerResponse->setCount($controllerResponse->getCount());
        }

        /** @var LambdaRequest $request */
        $request = $this->getDI()->get('request');

        if ( $request->isJSON() ) {

            if ( is_a($controllerResponse, 'RodinAPI\Response\Response') ) {

                $json = new JSONResponse($controllerResponse);
                return $json->send();

            } elseif ( empty($controllerResponse) ) {

                $this->response->setStatusCode(200);
                $this->response->setJsonContent(null);
                $this->response->setContentType('application/json');

                return $this->response->send();

            } else {

                throw new InternalErrorException('Unknown handled response');

            }

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

} catch (HandledException $e) {

    $response = new HTTPResponse();

    $response->setStatusCode(
        $e->getCode(),
        $e->getMessage()
    );

    if( empty($e->getResponseMessages()) ) {

        $response->addMessage(
            $e->getMessage(),
            ResponseMessage::TYPE_WARNING
        );

    } else {

        /**
         * @var ResponseMessage $responseMessage
         */
        foreach( $e->getResponseMessages() as $responseMessage ) {

            $response->addMessage(
                $responseMessage->text,
                $responseMessage->type
            );

        }

    }

    /** @var LambdaRequest $request */
    $di         = Di::getDefault();
    $request    = $di->get('request');

    if ( $request->isJSON() ) {

        $json = new JSONResponse($response, true);

        return $json->send();

    }

} catch (\Exception $e) {
    echo $e->getMessage();
}
