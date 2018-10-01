<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Iad\Bundle\FilerTechBundle\Repository\RealEstatePictureRepository")
 * @ORM\Table(
 *     name="filer_realestate_picture"
 * )
 */
class RealEstatePicture
{
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="rank", type="smallint", nullable=true)
     */
    protected $rank;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Iad\Bundle\FilerTechBundle\Entity\RealEstatePictureFile",
     *     mappedBy="realEstatePicture",
     *     cascade={"persist", "remove"}
     * )
     */
    private $files;

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
     * RealEstatePicture constructor.
     */
    public function __construct()
    {
        $this->files = new ArrayCollection();
    }


    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return RealEstatePicture
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     * @return RealEstatePicture
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return RealEstatePicture
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     *
     * @return RealEstatePicture
     */
    public function setFiles(ArrayCollection $files)
    {
        $this->files = $files;

        return $this;
    }


    /**
     * @param RealEstatePictureFile $file
     *
     * @return $this
     */
    public function addFile(RealEstatePictureFile $file)
    {
        if ($this->files->contains($file) === false) {
            if ($file->getRealEstatePicture() === null) {
                $file->setRealEstatePicture($this);
            }
            $this->files->add($file);
        }

        return $this;
    }

    /**
     * @param RealEstatePictureFile $file
     *
     * @return $this
     */
    public function removeFile(RealEstatePictureFile $file)
    {
        if ($this->files->contains($file) === true) {
            $this->files->removeElement($file);
        }

        return $this;
    }

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
     * @return RealEstatePicture
     */
    public function setOriginalFile(UploadedFile $originalFile)
    {
        $this->originalFile = $originalFile;

        return $this;
    }
}