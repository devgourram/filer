<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 10:41
 */

namespace Iad\Bundle\FilerTechBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 *
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
abstract class Picture implements PictureInterface, FilableInterface
{
    use TimestampableEntity;

    /**
     * @var integer
     *
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
     * @var PictureFileInterface|Collection
     * @ORM\OneToMany(targetEntity="PictureFile", mappedBy="picture", cascade={"persist"})
     */
    protected $files;


    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Picture
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Picture
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
     * @return Picture
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     * @return Picture
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @param PictureFile $file
     *
     * @return $this
     */
    public function addFile(PictureFileInterface $file)
    {
        if ($this->files->contains($file) === false) {
            $this->files->add($file);
            $file->setPicture($this);
        }

        return $this;
    }

    /**
     * @param PictureFile $file
     *
     * @return $this
     */
    public function removeFile(PictureFileInterface $file)
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
     * @return Picture
     */
    public function setOriginalFile($originalFile)
    {
        $this->originalFile = $originalFile;
        return $this;
    }

}