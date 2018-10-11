<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 02/10/18
 * Time: 08:51
 */

namespace Iad\Bundle\FilerTechBundle\Entity;

use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseDocument
 * @package Iad\Bundle\FilerTechBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="filer_base_document")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({})
 * @ORM\EntityListeners({"Iad\Bundle\FilerTechBundle\EventListener\DocumentListener"})
 */
class BaseDocument implements DocumentInterface
{
    use FilerTrait;

    /**
     * @var UploadedFile $originalFile
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypesMessage = "iad_filer.validation.realEstate.pictures.size",
     *     mimeTypes = {"image/gif", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "iad_filer.validation.realEstate.pictures.type",
     *     groups={"registration"}
     * )
     */
    private $originalFile;


    /**
     * @return UploadedFile
     */
    public function getOriginalFile()
    {
        return $this->originalFile;
    }

    /**
     * @param UploadedFile $originalFile
     * @return Document
     */
    public function setOriginalFile($originalFile)
    {
        $this->originalFile = $originalFile;
        return $this;
    }


}