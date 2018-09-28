<?php

namespace Iad\Bundle\FilerTechBundle\Business\Exception;

/**
 * Class DocumentNotFoundException
 * @package Iad\Bundle\FilerTechBundle\Business\Exception
 */
class DocumentSizeException extends \Exception
{
    /**
     * @param int $size
     * @param int $maxSize
     */
    public function __construct($size, $maxSize)
    {
        parent::__construct(sprintf('Document size exceeded: %d ko (max: %d ko)', $size, $maxSize));
    }
}
