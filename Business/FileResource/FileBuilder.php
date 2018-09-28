<?php

namespace Iad\Bundle\FilerTechBundle\Business\FileResource;

use Gaufrette\Adapter\Local as LocalAdapter;
use Gaufrette\File as FileGaufrette;
use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\EncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FilerResource
 * @package Iad\Bundle\FilerTechBundle\Business\FileResource
 */
class FileBuilder
{
    /**
     * @var EncoderInterface $encoder
     */
    protected $encoder;

    /**
     * @param EncoderInterface $encoder
     *
     */
    public function __construct(EncoderInterface $encoder)
    {
        $this->encoder    = $encoder;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string       $documentType
     * @param string       $access
     * @param array        $details
     * @return File
     */
    public function setFromFileUpload(UploadedFile $uploadedFile, $documentType, $access = 'private', array $details = null)
    {
        $fileGaufrette = new FileGaufrette($uploadedFile->getFilename(), $this->getFilesystem($access));
        $fileGaufrette->setContent(file_get_contents($uploadedFile->getPathname()));

        return $this->getFromFileGaufrette($fileGaufrette, $documentType, $access, $details);
    }

    /**
     * @param mixed  $data
     * @param string $name
     * @param string $documentType
     * @param string $access
     * @param array  $details
     *
     * @return File
     */
    public function getFromData($data, $name, $documentType, $access = 'private', array $details = null)
    {
        $path = 'iad-filer/'.uniqid();

        $fileSystem = new Filesystem(new LocalAdapter($this->rootPath));

        $fileReal = new FileGaufrette($path, $fileSystem);
        $fileReal->setContent($data);
        $fileReal->setName($name);

        return $this->getFromFileGaufrette($fileReal, $fileSystem, $documentType, $access, $details);
    }

    /**
     * @param FileGaufrette $fileGaufrette
     * @param string        $documentType
     * @param string        $access
     * @param array         $details
     * @return File
     */
    public function getFromFileGaufrette(FileGaufrette $fileGaufrette, $documentType, $access = 'private', array $details = null)
    {
        $mimeType = $this->getFilesystem($access)->mimeType($fileGaufrette->getKey());
        $checkSum = $this->encoder->hash($fileGaufrette->getContent());

        $file = new File($fileGaufrette);
        $file
            ->setAccess($access)
            ->setDetails($details)
            ->setType($documentType)
            ->setMimeType($mimeType)
            ->setName($fileGaufrette->getName())
            ->setHash($checkSum)
            ->setSize(floor($fileGaufrette->getSize() / 1000));

        return $file;
    }

    /**
     * @return Filesystem
     */
    public function getPrivateFilesystem()
    {
        return $this->privateFilesystem;
    }

    /**
     * @param Filesystem $privateFilesystem
     *
     * @return FileBuilder
     */
    public function setPrivateFilesystem($privateFilesystem)
    {
        $this->privateFilesystem = $privateFilesystem;

        return $this;
    }
}
