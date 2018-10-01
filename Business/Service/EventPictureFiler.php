<?php

namespace Iad\Bundle\FilerTechBundle\Business\Service;

use Gaufrette\Exception\FileNotFound;

use Iad\Bundle\FilerTechBundle\Business\AbstractImageFiler;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException;
use Iad\Bundle\FilerTechBundle\Business\FileResource\ImageFile;
use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;
use Iad\Bundle\FilerTechBundle\Entity\EventPicture;
use Iad\Bundle\FilerTechBundle\Entity\EventPictureFile;
use Iad\Bundle\FilerTechBundle\Manager\EventPictureManager;

/**
 * Class EventPictureFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class EventPictureFiler extends AbstractImageFiler
{
    /**
     * @var string
     */
    protected $directoryPrefix = 'event_pictures/';

    /**
     * @var string
     */
    protected $documentType = 'event_picture';

    /**
     * @var EventPictureManager
     */
    protected $eventPictureManager;

    /**
     * @var string
     */
    protected static $access = 'public';

    /**
     * @var string
     */
    protected static $defaultFilter = 'high';

    /**
     * @return EventPictureManager
     */
    public function getEventPictureManager()
    {
        return $this->eventPictureManager;
    }

    /**
     * @param EventPictureManager $eventPictureManager
     *
     * @return EventPictureFiler
     */
    public function setEventPictureManager($eventPictureManager)
    {
        $this->eventPictureManager = $eventPictureManager;
        $this->entityManager = $eventPictureManager->getManager();

        return $this;
    }

    /**
     * @param EventPicture   $eventPicture
     * @param integer        $idAuthor
     * @param array          $details
     * @param CropParameters $cropParameters
     *
     * @return EventPicture
     * @throws DocumentMimeTypeException
     */
    public function create(EventPicture $eventPicture, $idAuthor, $details = [], CropParameters $cropParameters = null)
    {
        $file = $this->createFile($eventPicture->getOriginalFile(), self::$access, $details);

        if ($cropParameters) {
            $file = $this->cropFile($file, $cropParameters);
        }

        if ($this->imageManager->isImage($file->getMimeType()) === false) {
            throw new DocumentMimeTypeException($file->getMimeType());
        }

        $eventPicture->setTitle($file->getName());
        $eventPictureFile = $this->createEventFile($file, $idAuthor, EventPictureFile::$sizeNameSource);
        $eventPicture->addFile($eventPictureFile);

        $resizedFiles = $this->getFilesFromFilters($file);

        $pictures = [];

        foreach ($resizedFiles as $filterName => $resizedFile) {
            $pictureResized = $this->createEventFile($resizedFile, $idAuthor, $filterName);
            $pictureResized->getDocumentObject()->setOriginalName($file->getName());
            $eventPicture->addFile($pictureResized);
            $pictures[] = $pictureResized;
        }

        return $eventPicture;
    }

    /**
     * @param EventPicture $picture
     *
     * @return null|string
     */
    public function getLink(EventPicture $picture)
    {
        $defaultFilter = (self::$defaultFilter ? self::$defaultFilter : 'source');

        /**
         * @var EventPictureFile $file
         */
        foreach ($picture->getFiles() as $file) {
            if ($defaultFilter === $file->getSizeName()) {
                return $this->getPublicBaseUrl().'/'.$file->getDocumentObject()->getFullName();
            }
        }

        return null;
    }

    /**
     * @param EventPicture $eventPicture
     * @param boolean      $force
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(EventPicture $eventPicture, $force = false)
    {
        /**
         * @var EventPictureFile $eventPictureFile
         */
        foreach ($eventPicture->getFiles() as $eventPictureFile) {
            try {
                return $this->deleteFromEntity($eventPictureFile->getDocumentObject());
            } catch (FileNotFound $e) {
                if (!$force) {
                    throw $e;
                }
            }
        }
    }

    /**
     * @param ImageFile $file
     * @param integer   $idAuthor
     * @param string    $filterName
     *
     * @return EventPictureFile
     */
    private function createEventFile(ImageFile $file, $idAuthor, $filterName)
    {
        $documentObject = $this->createDocumentObject($file, $idAuthor);
        $eventPictureFile = new EventPictureFile();
        $eventPictureFile
            ->setHeight($file->getHeight())
            ->setWidth($file->getWidth())
            ->setSizeName($filterName)
            ->setDocumentObject($documentObject);

        return $eventPictureFile;
    }
}
