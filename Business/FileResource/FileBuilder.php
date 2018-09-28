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
     * @var string
     */
    protected $rootPath;

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @param EncoderInterface $encoder
     * @param string           $rootPath
     */
    public function __construct(EncoderInterface $encoder, $rootPath = null)
    {
        $this->encoder  = $encoder;
        $this->rootPath = $rootPath === null ? sys_get_temp_dir() : $rootPath;
    }

    /**
     * @param UploadedFile $file
     * @param string       $documentType
     * @param string       $access
     * @param array        $details
     * @return File
     */
    public function getFromFileUpload(UploadedFile $file, $documentType, $access = 'private', array $details = null)
    {
        $fileSystem = new Filesystem(new LocalAdapter($file->getPath()));

        $fileReal = new FileGaufrette($file->getFilename(), $fileSystem);
        $fileReal->setName($file->getClientOriginalName());

        return $this->getFromFileGaufrette($fileReal, $fileSystem, $documentType, $access, $details);
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
     * @param FileGaufrette $fileReal
     * @param Filesystem    $fileSystem
     * @param string        $documentType
     * @param string        $access
     * @param array         $details
     * @return File
     */
    public function getFromFileGaufrette(FileGaufrette $fileReal, Filesystem $fileSystem, $documentType, $access = 'private', array $details = null)
    {
        $mimeType = $fileSystem->mimeType($fileReal->getKey());
        $checkSum = $this->encoder->hash($fileReal->getContent());

        $file = new File($fileReal);
        $file
            ->setAccess($access)
            ->setDetails($details)
            ->setType($documentType)
            ->setMimeType($mimeType)
            ->setName($fileReal->getName())
            ->setHash($checkSum)
            ->setSize(floor($fileReal->getSize() / 1000));

        return $file;
    }
}
