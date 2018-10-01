<?php

namespace Iad\Bundle\FilerTechBundle\Entity\Traits;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;

/**
 * Class FilerTrait
 *
 * @package Iad\Bundle\FilerTechBundle\Entity\Traits
 */
trait FilerTrait
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var DocumentObject
     *
     * @ORM\OneToOne(
     *     targetEntity="Iad\Bundle\FilerTechBundle\Entity\DocumentObject",
     *     cascade={"persist", "remove"}
     * )
     * @ORM\JoinColumn(name="id_document_object", referencedColumnName="id")
     */
    private $documentObject;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DocumentObject
     */
    public function getDocumentObject()
    {
        return $this->documentObject;
    }

    /**
     * @param DocumentObject $documentObject
     *
     * @return $this
     */
    public function setDocumentObject(DocumentObject $documentObject)
    {
        $this->documentObject = $documentObject;

        return $this;
    }
}
