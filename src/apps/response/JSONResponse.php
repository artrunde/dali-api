<?php
namespace DaliAPI\Response;

use DaliAPI\Request\LambdaRequest;
use Phalcon\Http\Response as HTTPResponse;

class JSONResponse extends HTTPResponse
{

    /** @var ResponseMeta */
    public $meta;

    /** @var ResponseMessage[] */
    public $messages;

    /** @var array */
    public $data;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {

        parent::__construct();

        $this->setStatusCode(
            $response->getStatusCode(),
            $response->getStatusMessage()
        );

        $this->data     = $response->getData();
        $this->meta     = $response->getMeta();
        $this->messages = $response->getMessages();

    }

    /**
     * Send the response
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function send()
    {
        // Set headers
        $this->setContentType('application/json');

        if (empty($this->messages)) {
            $this->messages = null;
        }

        if ( empty($this->data) ) {
            $this->data = null;
        }

        /** @var LambdaRequest $request */
        $request = $this->getDI()->get('request');

        /**
         * Check enveloped
         */
        if( true === $request->envelope() ) {
            $this->setContent(json_encode($this));
        } else {
            $this->setContent(json_encode($this->data));
        }

        // Send content
        return parent::send();

    }

    public function sendException(\Exception $exception)
    {
        $this->setStatusCode($exception->getCode(), $exception->getMessage());

        $this->setJsonContent($this);

        return parent::send();
    }
}
