<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\Routing\Router;

use Gaufrette\File as FileGaufrette;
use Gaufrette\Filesystem;

use Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentNotFoundException;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentSizeException;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentTypeException;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;

/**
 * Class Filer
 * @package Iad\Bundle\IadFilerTechBundle\Business
 */
class Filer
{
    /**
     * @var int
     */
    protected $fileMaxSize;

    /**
     * @var int
     */
    protected $imageMaxSize;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @var array
     */
    protected $documentTypes;

    /**
     * @var array
     */
    protected $mimeTypes;

    /**
     * @var DocumentObjectManager
     */
    protected $documentObjectManager;

    /**
     * @var string
     */
    protected $defaultImageFilter;

    /**
     * @var string
     */
    protected $defaultImageFormat;

    /**
     * @param EncoderInterface      $encoder
     * @param DocumentObjectManager $documentObjectManager
     * @param ImageManager          $imageManager
     * @param Router                $router
     * @param FileSystem            $fileSystem
     * @param string                $defaultImageFilter
     */
    public function __construct(EncoderInterface $encoder, DocumentObjectManager $documentObjectManager, ImageManager $imageManager, Router $router, FileSystem $fileSystem, $defaultImageFilter)
    {
        $this->fileMaxSize        = 50000;
        $this->imageMaxSize       = 10000;
        $this->defaultImageFormat = 'png';
        $this->defaultImageFilter = $defaultImageFilter;
        $this->documentTypes      = [];

        $this->documentObjectManager = $documentObjectManager;
        $this->imageManager          = $imageManager;
        $this->router                = $router;
        $this->encoder               = $encoder;
        $this->fileSystem            = $fileSystem;
    }

    /**
     * @param array $documentTypes
     *
     * @return $this
     */
    public function setDocumentTypes(array $documentTypes = [])
    {
        $this->documentTypes = $documentTypes;

        return $this;
    }

    /**
     * @return array
     */
    public function getDocumentTypes()
    {
        return $this->documentTypes;
    }

    /**
     * @param int $size Size Ko
     *
     * @return $this
     */
    public function setFileMaxSize($size)
    {
        $this->fileMaxSize = (int) $size;

        return $this;
    }

    /**
     * @param int $size Size Ko
     *
     * @return $this
     */
    public function setImageMaxSize($size)
    {
        $this->imageMaxSize = (int) $size;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return $this
     */
    public function setDefaultImageFormat($format)
    {
        $this->defaultImageFormat = $format;

        return $this;
    }

    /**
     * @param string $filter
     *
     * @return $this
     */
    public function setDefaultImageFilter($filter)
    {
        $this->defaultImageFilter = $filter;

        return $this;
    }

    /**
     * @return FileBuilder
     */
    public function getFileBuilder()
    {
        return new FileBuilder($this->encoder);
    }

    /**
     * @param File $file
     * @return bool
     * @throws DocumentMimeTypeException
     * @throws DocumentSizeException
     * @throws DocumentTypeException
     */
    public function checkFile(File $file)
    {
        // known type
        if (!in_array($file->getType(), $this->documentTypes, true)) {
            throw new DocumentTypeException($file->getType());
        }

        // Mime type
        if (!in_array($file->getMimeType(), $this->mimeTypes)) {
            throw new DocumentMimeTypeException($file->getMimeType());
        }

        // File size
        if ($file->getSize() >= $this->fileMaxSize) {
            throw new DocumentSizeException($file->getSize(), $this->fileMaxSize);
        }

        // Image size
        if ($this->isImage($file) && $file->getSize() > $this->imageMaxSize) {
            $params = new ResizeParameters();
            $file->setContent($this->resize($file, $params));
        }

        return true;
    }

    /**
     * @param File   $file
     * @param string $idUploader
     * @return array
     * @throws DocumentSizeException
     * @throws DocumentTypeException
     */
    public function save(File $file, $idUploader)
    {
        $this->checkFile($file);

        $uuid = $this->encoder->uuid($file->getContent());
        $directory = $this->formatDirectory($file->getType());

        $extensionGuesser = ExtensionGuesser::getInstance();

        $path = $directory.'/'.$uuid.'.'.$extensionGuesser->guess($file->getMimeType());

        $finalFile = new FileGaufrette($path, $this->fileSystem);
        $finalFile->setContent($file->getContent());

        $documentObject = $this->documentObjectManager->create();
        $documentObject
            ->setUuid($uuid)
            ->setMimeType($file->getMimeType())
            ->setAccess($file->getAccess())
            ->setCheckSum($file->getHash())
            ->setDetails($file->getDetails())
            ->setDocumentType($file->getType())
            ->setFullName($path)
            ->setSize($file->getSize())
            ->setOriginalName($file->getName())
            ->setPathDirectory($directory)
            ->setIdUploader($idUploader);

        $this->documentObjectManager->persist($documentObject);
        $this->documentObjectManager->flush();

        return $documentObject;
    }

    /**
     * @param array $mimeTypes
     * @return $this
     */
    public function setMimeTypes($mimeTypes)
    {
        $this->mimeTypes = $mimeTypes;

        return $this;
    }

    /**
     * @param string $uuid
     * @return File
     * @throws DocumentNotFoundException
     */
    public function getFile($uuid)
    {
        $documentObject = $this->getDocumentObject($uuid);

        $path = $this->formatDirectory($documentObject->getDocumentType()).'/'.$uuid;

        return new FileGaufrette($path, $this->fileSystem);
    }

    /**
     * @param string $uuid
     * @return File
     * @throws DocumentNotFoundException
     */
    public function get($uuid)
    {
        $documentObject = $this->getDocumentObject($uuid);

        $file = new File(new FileGaufrette($documentObject->getFullName(), $this->fileSystem));
        $this->bindMetadata($file, $documentObject);

        return $file;
    }

    /**
     * @param string $uuid
     * @return File
     * @throws DocumentNotFoundException
     */
    public function getMetaData($uuid)
    {
        $documentObject = $this->getDocumentObject($uuid);

        $file = new File();
        $this->bindMetadata($file, $documentObject);

        return $file;
    }

    /**
     * @param File $file
     * @return int
     */
    public function isImage(File $file)
    {
        return $this->imageManager->isImage($file->getMimeType());
    }

    /**
     * @param File             $file
     * @param ResizeParameters $params
     * @return File|string
     */
    public function resize(File $file, ResizeParameters $params)
    {
        if ($this->isImage($file)) {
            $mimeType = $file->getMimeType();

            if ($params->getFilter() === null) {
                $params->setFilter($this->defaultImageFilter);
            }

            $binary = $this->imageManager->createBinary(
                $file->getContent(),
                $mimeType
            );

            return $this->imageManager->filter($binary, $params);
        }

        return $file;
    }

    /**
     * @param string $uuid
     * @return string
     */
    public function generateDownloadUrl($uuid)
    {
        return $this->router->generate(
            'iad_filer_document_download',
            ['uuid' => $uuid],
            true
        );
    }

    protected function bindMetadata(File $file, DocumentObject $documentObject)
    {
        $url = $this->generateDownloadUrl($documentObject->getUuid());

        $file
            ->setSize($documentObject->getSize())
            ->setName($documentObject->getOriginalName())
            ->setAccess($documentObject->getAccess())
            ->setHash($documentObject->getCheckSum())
            ->setMimeType($documentObject->getMimeType())
            ->setType($documentObject->getDocumentType())
            ->setUuid($documentObject->getUuid())
            ->setUrl($url);

        return $file;
    }

    /**
     * @param string $uuid
     * @return DocumentObject
     * @throws DocumentNotFoundException
     */
    protected function getDocumentObject($uuid)
    {
        $documentObject = $this->documentObjectManager->findOneByUuid($uuid);

        if (!$documentObject) {
            throw new DocumentNotFoundException($uuid);
        }

        return $documentObject;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function formatDirectory($name)
    {
        return preg_replace('#[^a-z0-9]#', '_', strtolower($name));
    }
}
