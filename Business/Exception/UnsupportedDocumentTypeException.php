<?php

namespace Iad\Bundle\FilerTechBundle\Business\Exception;

/**
 * Class UnsupportedDocumentTypeException
 * @package Iad\Bundle\FilerTechBundle\Business\Exception
 */
class UnsupportedDocumentTypeException extends \Exception
{
    /**
     * @param mixed $object
     */
    public function __construct($object)
    {
        if (is_object($object) === false) {
            parent::__construct(sprintf('Filer: Document given is not an object'));
        } else {
            parent::__construct(sprintf('Filer: Document type: %s is unsupported', get_class($object)));
        }
    }
}
