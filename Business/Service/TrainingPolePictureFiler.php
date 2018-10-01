<?php

namespace Iad\Bundle\FilerTechBundle\Business\Service;

use Gaufrette\Exception\FileNotFound;

use Iad\Bundle\FilerTechBundle\Business\AbstractImageFiler;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException;
use Iad\Bundle\FilerTechBundle\Business\FileResource\ImageFile;
use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePicture;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePictureFile;
use Iad\Bundle\FilerTechBundle\Manager\TrainingPolePictureManager;

/**
 * Class TrainingPolePictureFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class TrainingPolePictureFiler extends AbstractImageFiler
{
    /**
     * @var string
     */
    protected $directoryPrefix = 'training_pole_pictures/';

    /**
     * @var string
     */
    protected $documentType = 'training_pole_picture';

    /**
     * @var TrainingPolePictureManager
     */
    protected $trainingPolePictureManager;

    /**
     * @var string
     */
    protected static $access = 'public';

    /**
     * @var string
     */
    protected static $defaultFilter = 'high';

    /**
     * @return TrainingPolePictureManager
     */
    public function getTrainingPolePictureManager()
    {
        return $this->trainingPolePictureManager;
    }

    /**
     * @param TrainingPolePictureManager $trainingPolePictureManager
     *
     * @return TrainingPolePictureFiler
     */
    public function setTrainingPolePictureManager(TrainingPolePictureManager $trainingPolePictureManager)
    {
        $this->trainingPolePictureManager = $trainingPolePictureManager;
        $this->entityManager = $trainingPolePictureManager->getManager();

        return $this;
    }

    /**
     * @param TrainingPolePicture $trainingPolePicture
     * @param integer             $idAuthor
     * @param array               $details
     * @param CropParameters      $cropParameters
     *
     * @return TrainingPolePicture
     * @throws DocumentMimeTypeException
     */
    public function create(TrainingPolePicture $trainingPolePicture, $idAuthor, $details = [], CropParameters $cropParameters = null)
    {
        $file = $this->createFile($trainingPolePicture->getOriginalFile(), self::$access, $details);

        if ($cropParameters) {
            $file = $this->cropFile($file, $cropParameters);
        }

        if ($this->imageManager->isImage($file->getMimeType()) === false) {
            throw new DocumentMimeTypeException($file->getMimeType());
        }

        $trainingPolePicture->setTitle($file->getName());
        $trainingPolePictureFile = $this->createTrainingPoleFile($file, $idAuthor, TrainingPolePictureFile::$sizeNameSource);
        $trainingPolePicture->addFile($trainingPolePictureFile);

        $resizedFiles = $this->getFilesFromFilters($file);

        $pictures = [];

        foreach ($resizedFiles as $filterName => $resizedFile) {
            $pictureResized = $this->createTrainingPoleFile($resizedFile, $idAuthor, $filterName);
            $pictureResized->getDocumentObject()->setOriginalName($file->getName());
            $trainingPolePicture->addFile($pictureResized);
            $pictures[] = $pictureResized;
        }

        return $trainingPolePicture;
    }

    /**
     * @param TrainingPolePicture $picture
     *
     * @return null|string
     */
    public function getLink(TrainingPolePicture $picture)
    {
        $defaultFilter = (self::$defaultFilter ? self::$defaultFilter : 'source');

        /**
         * @var TrainingPolePicture $file
         */
        foreach ($picture->getFiles() as $file) {
            if ($defaultFilter === $file->getSizeName()) {
                return $this->getPublicBaseUrl().'/'.$file->getDocumentObject()->getFullName();
            }
        }

        return null;
    }

    /**
     * @param TrainingPolePicture $trainingPolePicture
     * @param boolean             $force
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(TrainingPolePicture $trainingPolePicture, $force = false)
    {
        /**
         * @var TrainingPolePicture $trainingPolePicture
         */
        foreach ($trainingPolePicture->getFiles() as $trainingPolePictureFile) {
            try {
                return $this->deleteFromEntity($trainingPolePictureFile->getDocumentObject());
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
     * @return TrainingPolePictureFile
     */
    private function createTrainingPoleFile(ImageFile $file, $idAuthor, $filterName)
    {
        $documentObject = $this->createDocumentObject($file, $idAuthor);
        $trainingPolePictureFile = new TrainingPolePictureFile();
        $trainingPolePictureFile
            ->setHeight($file->getHeight())
            ->setWidth($file->getWidth())
            ->setSizeName($filterName)
            ->setDocumentObject($documentObject);

        return $trainingPolePictureFile;
    }
}
