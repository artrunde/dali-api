<?php

namespace RodinAPI\Exceptions;

use Phalcon\Validation\Message;
use Phalcon\Validation\Message\Group;
use RodinAPI\Response\ResponseMessage;

/**
 * Class HandledException
 * @package RodinAPI\Exceptions
 */
abstract class HandledException extends \Exception
{

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $code = 500;

    /**
     * @desc ResponseMessage[]
     * @var array
     */
    protected $responseMessages = [];

    public function getResponseMessages() {
        return $this->responseMessages;
    }

    /**
     * @param Group $validationMessages
     */
    public function addValidatorMessages( Group $validationMessages )
    {

        /**
         * @var Message $message
         */
        foreach ($validationMessages as $message) {
            $this->responseMessages[] = new ResponseMessage( $message->getType().' '.$message->getField().': '.$message->getMessage(), ResponseMessage::TYPE_WARNING );
        }

    }

    public function __construct( $message = "", $code = 0, \Exception $previous = null )
    {
        $this->message = empty($message) ? $this->message : $message;
    }

}
