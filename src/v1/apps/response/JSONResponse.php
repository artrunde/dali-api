<?php
namespace RodinAPI\Response;

use RodinAPI\Request\LambdaRequest;
use Phalcon\Http\Response as HTTPResponse;

class JSONResponse extends HTTPResponse
{

    /** @var ResponseMeta */
    public $meta;

    /** @var ResponseMessage[] */
    public $messages;

    /** @var array */
    public $data;

    protected $envelope = false;

    /**
     * JSONResponse constructor.
     * @param Response $response
     * @param bool $envelope
     */
    public function __construct(Response $response, $envelope = false)
    {

        parent::__construct();

        $this->setStatusCode(
            $response->getStatusCode(),
            $response->getStatusMessage()
        );

        $this->data     = $response->getData();
        $this->meta     = $response->getMeta();
        $this->messages = $response->getMessages();
        $this->envelope = $envelope; // This is useful for exceptions

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
        if( true === $request->envelope() || true === $this->envelope ) {
            $this->setContent(json_encode($this));
        } else {
            $this->setContent(json_encode($this->data));
        }

        // Set version in header
        $this->setHeader('X-rodin-version', $this->meta->version.' build '.$this->meta->build);

        // Send content
        return parent::send();

    }

}
