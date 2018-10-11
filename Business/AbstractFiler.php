<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Doctrine\ORM\EntityManager;
use Gaufrette\Exception\FileNotFound;
use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder;
use Iad\Bundle\FilerTechBundle\Config\Configuration;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Model\Binary;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
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
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var FileBuilder $privateFileBuilder
     */
    protected $privateFileBuilder;

    /**
     * @var FileBuilder $publicFileBuilder
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
     * @var string $publicBaseUrl
     */
    protected $publicBaseUrl;

    /**
     * @var Router $router
     */
    protected $router;

    /**
     * AbstractFiler constructor.
     *
     * @param Encoder $encoder
     */
    public function __construct(Encoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @var Iad\Bundle\FilerTechBundle\Config\Configuration|Collection
     */
    protected $configurations = [];

    /**
     * @return Iad\Bundle\FilerTechBundle\Config\Configuration
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }

    /**
     * @param Iad\Bundle\FilerTechBundle\Config\Configuration $configuration
     *
     * @return AbstractFiler
     */
    public function setConfiguration($configurations)
    {
        $this->configurations = $configurations;

        return $this;
    }

    public function addConfiguration($configuration)
    {
        $config = \Iad\Bundle\FilerTechBundle\Config\Configuration::createConfiguration($configuration);
        if (!isset($this->configurations[$config->getClass()])) {
            $this->configurations[$config->getClass()] = $config;
        }
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
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return AbstractFiler
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

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
    public function setEncoder(Encoder $encoder)
    {
        $this->encoder = $encoder;

        return $this;
    }

    /**
     * extract data from uploadedFile, create FileGaufrette and persist file in the filesystem
     *
     * @param File         $file
     * @param UploadedFile $uploadedFile
     * @param string       $access
     * @param array        $details
     *
     * @return File
     */
    public function processFile(File $file, UploadedFile $uploadedFile, $access, $details = null)
    {
        $content  = file_get_contents($uploadedFile->getPathname());
        $uuid     = $this->encoder->uuid($content);
        $checkSum = $this->encoder->hash($content);

        $fileGaufrette = $this->createFileGaufrette($uuid, $uploadedFile->getMimeType(), $content, $access);

        $file
            ->setMimeType($uploadedFile->getMimeType())
            ->setSize($fileGaufrette->getSize())
            ->setName($uploadedFile->getClientOriginalName())
            ->setUuid($uuid)
            ->setChecksum($checkSum)
            ->setContent($fileGaufrette->getContent())
            ->setDocumentType($this->documentType)
            ->setDetails($details)
            ->setAccess($access)
            ->setFullName($fileGaufrette->getKey());

        return $file;
    }

    /**
     * @param string $uuid
     * @param string $mimetype
     * @param string $content
     * @param string $access
     *
     * @return FileGaufrette
     */
    public function createFileGaufrette($uuid, $mimetype, $content, $access)
    {
        $extensionGuesser = ExtensionGuesser::getInstance();
        $extension        = $extensionGuesser->guess($mimetype);

        $fileName = $uuid.($extension ? '.'.$extension : '');
        $fullName = $this->directoryPrefix.$fileName;

        $fileGaufrette = new FileGaufrette($fullName, $this->getFilesystem($access));

        $fileGaufrette->setContent($content);

        return $fileGaufrette;
    }

    /**
     * @param string $filename
     * @param string $access
     *
     * @return FileGaufrette
     */
    public function loadFileGaufrette($filename, $access)
    {
        $fileGaufrette = new FileGaufrette($filename, $this->getFilesystem($access));

        return $fileGaufrette;
    }

    /**
     * @param File    $file
     * @param integer $idPeople
     * @param mixed $object
     *
     * @return DocumentObject
     */
    public function createDocumentObject(File $file, $idPeople, $object)
    {
        /**
         * @var Configuration $config
         */
        $config = $this->configurations[get_class($object)];
        $documentObject = new DocumentObject();
        $documentObject
            ->setUuid($file->getUuid())
            ->setMimeType($file->getMimeType())
            ->setAccess($file->getAccess())
            ->setCheckSum($file->getChecksum())
            ->setDetails($file->getDetails())
            ->setDocumentType($config->getDocumentType())
            ->setFullName($file->getFullName())
            ->setSize($file->getSize())
            ->setOriginalName($file->getName())
            ->setPathDirectory($config->getDirectoryPrefix())
            ->setIdUploader($idPeople);

        return $documentObject;
    }

    /**
     * @param DocumentObject $documentObject
     *
     * @return File
     */
    public function createFileFromEntity(DocumentObject $documentObject)
    {
        $file          = $this->getFileFromEntity($documentObject);
        $fileGaufrette = $this->loadFileGaufrette($documentObject->getFullName(), $documentObject->getAccess());

        $file->setContent($fileGaufrette->getContent());

        return $file;
    }

    /**
     * @param DocumentObject $documentObject
     *
     * @return bool
     */
    public function deleteFromEntity(DocumentObject $documentObject)
    {
        $fileGaufrette = $this->loadFileGaufrette($documentObject->getFullName(), $documentObject->getAccess());

        return $fileGaufrette->delete();
    }

    /**
     * @param DocumentObject $documentObject
     *
     * @return File
     */
    public function getFileFromEntity(DocumentObject $documentObject)
    {
        $file = new File();
        $file
            ->setMimeType($documentObject->getMimeType())
            ->setSize($documentObject->getSize())
            ->setName($documentObject->getOriginalName())
            ->setUuid($documentObject->getUuid())
            ->setChecksum($documentObject->getCheckSum())
            ->setDocumentType($documentObject->getDocumentType())
            ->setDetails($documentObject->getDetails())
            ->setAccess($documentObject->getAccess());

        return $file;
    }

    /**
     * @return string
     */
    public function getPublicBaseUrl()
    {
        return $this->publicBaseUrl;
    }

    /**
     * @param string $publicBaseUrl
     *
     * @return AbstractFiler
     */
    public function setPublicBaseUrl($publicBaseUrl)
    {
        $this->publicBaseUrl = $publicBaseUrl;

        return $this;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Router $router
     *
     * @return AbstractFiler
     */
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * @param DocumentObject $documentObject
     * @param bool           $force
     *
     * @return bool
     */
    public function deleteDocument(DocumentObject $documentObject, $force = false)
    {
        try {
            return $this->deleteFromEntity($documentObject);
        } catch (FileNotFound $e) {
            if (!$force) {
                throw $e;
            }
        }
    }

    /**
     * @param mixed  $content
     * @param string $mimeType
     *
     * @return Binary
     */
    public function createBinary($content, $mimeType = null)
    {
        if (!$mimeType) {
            $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $fileInfo->buffer($content);
        }

        $extensionGuesser = ExtensionGuesser::getInstance();
        $format           = $extensionGuesser->guess($mimeType);

        return new Binary(
            $content,
            $mimeType,
            $format
        );
    }

    /**
     * @param File            $file
     * @param BinaryInterface $binary
     * @param string          $access
     *
     * @return File
     */
    protected function setFileFromBinary(File $file, BinaryInterface $binary, $access)
    {
        $content       = $binary->getContent();
        $uuid          = $this->encoder->uuid($content);
        $checkSum      = $this->encoder->hash($content);
        $fileGaufrette = $this->createFileGaufrette(
            $uuid,
            $binary->getMimeType(),
            $content,
            $access
        );
        $file
            ->setMimeType($binary->getMimeType())
            ->setSize($fileGaufrette->getSize())
            ->setUuid($uuid)
            ->setChecksum($checkSum)
            ->setContent($fileGaufrette->getContent())
            ->setDocumentType($this->documentType)
            ->setAccess($access)
            ->setFullName($fileGaufrette->getKey());

        return $file;
    }
}
