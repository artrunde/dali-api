<?php
namespace RodinAPI\Response;

class TagCategoryResponse extends Response
{

    /**
     * @var string
     */
    public $class;

    /**
     * @var string
     */
    public $attribute;

    /**
     * TagCategoryResponse constructor.
     * @param $class
     * @param $attribute
     */
    public function __construct($class, $attribute)
    {
        $this->class        = $class;
        $this->attribute    = $attribute;

        parent::__construct();
    }

}