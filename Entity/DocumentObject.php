<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class DocumentObject
 *
 * @ORM\Table(name="filer_document_object")
 * @ORM\Entity
 *
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
class DocumentObject
{

    use TimestampableEntity;

    const ACCESS_TYPE   = 'private';
    const ACCESS_PUBLIC = 'public';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string")
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="access", type="string")
     */
    private $access;

    /**
     * @var string
     *
     * @ORM\Column(name="check_sum", type="string")
     */
    private $checkSum;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string")
     */
    private $mimeType;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string")
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="original_name", type="string")
     */
    private $originalName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_uploader", type="integer")
     */
    private $idUploader;

    /**
     * @var string
     *
     * @ORM\Column(name="path_directory", type="string")
     */
    private $pathDirectory;

    /**
     * @var string
     *
     * @ORM\Column(name="document_type", type="string")
     */
    private $documentType;

    /**
     * @var array
     *
     * @ORM\Column(name="details", type="json_array", nullable=true)
     */
    private $details;

    /**
     *
     */
    public function __construct()
    {
        $this->access       = self::ACCESS_TYPE;
        $this->createdAt    = new \DateTime();
        $this->updatedAt    = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param string $access
     * @return $this
     * @throws \Exception
     */
    public function setAccess($access)
    {
        if (!in_array($access, self::getAllAccess(), true)) {
            throw new \Exception('Access '.$access.' unknown');
        }

        $this->access = $access;

        return $this;
    }

    /**
     * @return array
     */
    public static function getAllAccess()
    {
        return [self::ACCESS_PUBLIC, self::ACCESS_TYPE];
    }

    /**
     * @return string
     */
    public function getCheckSum()
    {
        return $this->checkSum;
    }

    /**
     * @param string $checkSum
     * @return $this
     */
    public function setCheckSum($checkSum)
    {
        $this->checkSum = $checkSum;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $mimeType
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param mixed $originalName
     * @return $this
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUploader()
    {
        return $this->idUploader;
    }

    /**
     * @param integer $idUploader
     * @return $this
     */
    public function setIdUploader($idUploader)
    {
        $this->idUploader = $idUploader;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPathDirectory()
    {
        return $this->pathDirectory;
    }

    /**
     * @param mixed $pathDirectory
     * @return $this
     */
    public function setPathDirectory($pathDirectory)
    {
        $this->pathDirectory = $pathDirectory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * @param string $documentType
     * @return $this
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * @return array
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param array $details
     * @return $this
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }
}
