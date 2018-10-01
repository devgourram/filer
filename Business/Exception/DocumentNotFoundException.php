<?php

namespace Iad\Bundle\FilerTechBundle\Business\Exception;

/**
 * Class DocumentNotFoundException
 *
 * @package Iad\Bundle\FilerTechBundle\Business\Exception
 */
class DocumentNotFoundException extends \Exception
{
    /**
     * @param string $uuid
     */
    public function __construct($uuid)
    {
        parent::__construct(sprintf('Document with uuid "%s" not found', $uuid));
    }
}
