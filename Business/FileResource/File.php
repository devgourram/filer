<?php

namespace Iad\Bundle\FilerTechBundle\Business\FileResource;

use JMS\Serializer\Annotation as JMS;

/**
 * Class File
 *
 * @package Iad\Bundle\FilerTechBundle\Business\FileResource
 *
 * @JMS\ExclusionPolicy("all")
 */
class File
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $access;

    /**
     * @var array
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $details;

    /**
     * @var integer $size
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $size;

    /**
     * @var string $name
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $name;

    /**
     * @var string $documentType
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $documentType;

    /**
     * @var string $uuid
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $uuid;

    /**
     * @var string $checksum
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $checksum;

    /**
     * @var string
     */
    protected $fullName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $mimeType;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $url;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var integer $width
     */
    protected $width;

    /**
     * @var integer $height
     */
    protected $height;

    /**
     * @JMS\VirtualProperty
     * @JMS\Groups({"content"})
     *
     * @return string
     */
    public function getBase64Content()
    {
        return base64_encode($this->getContent());
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * @param string $documentType
     *
     * @return $this
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;

        return $this;
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
     *
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
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * @param string $checksum
     *
     * @return $this
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param mixed $access
     *
     * @return $this
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param array $details
     *
     * @return $this
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setContent($data)
    {
        $this->content = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     *
     * @return File
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return File
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return File
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }
}
