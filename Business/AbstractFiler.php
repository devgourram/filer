<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gaufrette\File as FileGaufrette;

/**
 * Interface FilerInterface
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
abstract class AbstractFiler
{
    /**
     * @var string $directoryPrefix
     */
    protected $directoryPrefix = '';

    /**
     * @var string
     */
    protected $documentType = '';

    /**
     * @var DocumentObjectManager $documentObjectManager
     */
    protected $documentObjectManager;

    /**
     * @var FileBuilder $fileBuilder
     */
    protected $privateFileBuilder;

    /**
     * @var FileBuilder $fileBuilder
     */
    protected $publicFileBuilder;

    /**
     * @var Filesystem $publicFilesystem
     */
    protected $publicFilesystem;

    /**
     * @var Filesystem $privateFilesystem
     */
    protected $privateFilesystem;

    /**
     * @var Encoder $encoder
     */
    protected $encoder;


    /**
     * AbstractFiler constructor.
     *
     * @param Encoder $encoder
     */
    public function __construct(Encoder $encoder)
    {
        $this->encoder     = $encoder;
    }

    /**
     * @return Filesystem
     */
    public function getPublicFilesystem()
    {
        return $this->publicFilesystem;
    }

    /**
     * @param Filesystem $publicFilesystem
     *
     * @return AbstractFiler
     */
    public function setPublicFilesystem(Filesystem $publicFilesystem)
    {
        $this->publicFilesystem = $publicFilesystem;

        return $this;
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
     * @return AbstractFiler
     */
    public function setPrivateFilesystem(Filesystem $privateFilesystem)
    {
        $this->privateFilesystem = $privateFilesystem;

        return $this;
    }

    /**
     * @param string $access
     *
     * @return Filesystem
     */
    public function getFilesystem($access = 'private')
    {
        if (!in_array($access, ['private', 'public'])) {
            throw new \InvalidArgumentException("access parameter must be private or public");
        }
        $method = 'get'.ucfirst($access).'Filesystem';

        return $this->$method();
    }

    /**
     * @return DocumentObjectManager
     */
    public function getDocumentObjectManager()
    {
        return $this->documentObjectManager;
    }

    /**
     * @param DocumentObjectManager $documentObjectManager
     *
     * @return AbstractFiler
     */
    public function setDocumentObjectManager($documentObjectManager)
    {
        $this->documentObjectManager = $documentObjectManager;

        return $this;
    }

    /**
     * @return Encoder
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * @param Encoder $encoder
     *
     * @return AbstractFiler
     */
    public function setEncoder($encoder)
    {
        $this->encoder = $encoder;

        return $this;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string       $access
     * @param string       $details
     *
     * @return File
     */
    public function createFile(UploadedFile $uploadedFile, $access, $details)
    {
        $content          = file_get_contents($uploadedFile->getPathname());
        $uuid             = $this->encoder->uuid($content);
        $checkSum         = $this->encoder->hash($content);

        $file = new File();
        $file
            ->setMimeType($uploadedFile->getMimeType())
            ->setSize($uploadedFile->getSize())
            ->setName($uploadedFile->getClientOriginalName())
            ->setUuid($uuid)
            ->setChecksum($checkSum)
            ->setContent($content)
            ->setDocumentType($this->documentType)
            ->setDetails($details)
            ->setAccess($access)
        ;

        return $file;
    }

    /**
     * @param File   $file
     * @param string $access
     *
     * @return FileGaufrette
     */
    public function createFileGaufrette(File $file, $access = 'private')
    {
        $extensionGuesser = ExtensionGuesser::getInstance();
        $extension        = $extensionGuesser->guess($file->getMimeType());
        $fileName         = $file->getUuid().($extension?'.'.$extension:'');
        $fullName         = $this->directoryPrefix.$fileName;

        $fileGaufrette    = new FileGaufrette($fullName, $this->getFilesystem($access));

        return $fileGaufrette;
    }

    /**
     * @param File          $file
     * @param FileGaufrette $fileGaufrette
     * @param integer       $peopleId
     *
     * @return DocumentObject
     */
    public function createDocumentObject(File $file, FileGaufrette $fileGaufrette, $peopleId)
    {
        $documentObject = $this->getDocumentObjectManager()->create();
        $documentObject
            ->setUuid($file->getUuid())
            ->setMimeType($file->getMimeType())
            ->setAccess($file->getAccess())
            ->setCheckSum($file->getChecksum())
            ->setDetails($file->getDetails())
            ->setDocumentType($file->getDocumentType())
            ->setFullName($fileGaufrette->getKey())
            ->setSize($file->getSize())
            ->setOriginalName($file->getName())
            ->setPathDirectory($this->directoryPrefix)
            ->setIdUploader($peopleId);

        return $documentObject;
    }
}
