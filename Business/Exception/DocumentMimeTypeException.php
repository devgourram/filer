<?php

namespace Iad\Bundle\FilerTechBundle\Business\Exception;

/**
 * Class DocumentMimeTypeException
 * @package Iad\Bundle\FilerTechBundle\Business\Exception
 */
class DocumentMimeTypeException extends \Exception
{
    /**
     * @param string $mimeType
     */
    public function __construct($mimeType)
    {
        parent::__construct(sprintf('Document mime type "%s" unavailable', $mimeType));
    }
}
