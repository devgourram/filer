<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="filer_administrative_document")
 *
 */
class AdministrativeDocument
{
    use FilerTrait;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var UploadedFile $originalFile
     *
     * @Assert\File(
     *     maxSize = "50M",
     *     mimeTypesMessage = "iad_filer.validation.admdocument.size",
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
     *
     * @return $this
     */
    public function setOriginalFile(UploadedFile $originalFile)
    {
        $this->originalFile = $originalFile;

        return $this;
    }
}
