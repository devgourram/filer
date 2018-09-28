<?php

namespace Iad\Bundle\FilerTechBundle\Business\Exception;

/**
 * Class DocumentTypeException
 * @package Iad\Bundle\FilerTechBundle\Business\Exception
 */
class DocumentTypeException extends \Exception
{
    /**
     * @param string $type
     */
    public function __construct($type)
    {
        parent::__construct(sprintf('Document type "%s" unavailable', $type));
    }
}
