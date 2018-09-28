<?php

namespace Iad\Bundle\FilerTechBundle\Business\FileResource;

use Gaufrette\File as FileGaufrette;
use JMS\Serializer\Annotation as JMS;

/**
 * Class File
 * @package Iad\Bundle\FilerTechBundle\Business\FileResource
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
     * @var string $type
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $type;

    /**
     * @var string $uuid
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $uuid;

    /**
     * @var string $hash
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $hash;

    /**
     * @var FileGaufrette
     */
    protected $file;

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
     * @param FileGaufrette $file
     */
    public function __construct(FileGaufrette $file = null)
    {
        $this->setFile($file);
    }

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
     * @return FileGaufrette
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param FileGaufrette $file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

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
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     *
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

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
        if ($this->file instanceof FileGaufrette) {
            return $this->file->getContent();
        }

        return null;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setContent($data)
    {
        if ($this->file instanceof FileGaufrette) {
            $this->file->setContent($data);
        }

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
}
