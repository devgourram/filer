<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder;
use Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager;

/**
 * Class AvatarFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class FilerFactory
{
    /**
     * @var DocumentObjectManager $documentObjectManager
     */
    protected $documentObjectManager;

    /**
     * @var FileBuilder $fileBuilder
     */
    protected $fileBuilder;

    /**
     * @var Encoder $encoder
     */
    protected $encoder;

    /**
     * FilerFactory constructor.
     *
     * @param DocumentObjectManager $documentObjectManager
     * @param Encoder               $encoder
     */
    public function __construct(DocumentObjectManager $documentObjectManager, Encoder $encoder)
    {
        $this->documentObjectManager = $documentObjectManager;
        $this->encoder               = $encoder;
    }

    /**
     * @return AvatarFiler
     */
    public function createAvatarFiler()
    {
        $avatarFiler = new AvatarFiler($this->encoder);
        $avatarFiler
            ->setDocumentObjectManager($this->documentObjectManager)
            ;

        return $avatarFiler;
    }
}
