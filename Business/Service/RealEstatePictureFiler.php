<?php

namespace Iad\Bundle\FilerTechBundle\Business\Service;

use Gaufrette\Exception\FileNotFound;
use Iad\Bundle\FilerTechBundle\Business\AbstractImageFiler;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException;
use Iad\Bundle\FilerTechBundle\Business\FileResource\ImageFile;
use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePictureFile;
use Iad\Bundle\FilerTechBundle\Manager\RealEstatePictureManager;

/**
 * Class RealEstatePictureFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class RealEstatePictureFiler extends AbstractImageFiler
{
    /**
     * @var string
     */
    protected $directoryPrefix = 'real_estate_pictures/';

    /**
     * @var string
     */
    protected $documentType = 'real_estate_picture';

    /**
     * @var RealEstatePictureManager
     */
    protected $realEstatePictureManager;

    /**
     * @var string
     */
    protected static $access = 'public';

    /**
     * @var string
     */
    protected static $defaultFilter = 'high';

    /**
     * @return RealEstatePictureManager
     */
    public function getRealEstatePictureManager()
    {
        return $this->realEstatePictureManager;
    }

    /**
     * @param RealEstatePictureManager $realEstatePictureManager
     *
     * @return RealEstatePictureFiler
     */
    public function setRealEstatePictureManager($realEstatePictureManager)
    {
        $this->realEstatePictureManager = $realEstatePictureManager;
        $this->entityManager = $realEstatePictureManager->getManager();

        return $this;
    }

    /**
     * @param RealEstatePicture $realEstatePicture
     * @param integer           $idAuthor
     * @param array             $details
     * @param CropParameters    $cropParameters
     *
     * @return RealEstatePicture
     * @throws DocumentMimeTypeException
     */
    public function create(RealEstatePicture $realEstatePicture, $idAuthor, $details = [], CropParameters $cropParameters = null)
    {
        $file = $this->createFile($realEstatePicture->getOriginalFile(), self::$access, $details);

        if ($cropParameters) {
            $file = $this->cropFile($file, $cropParameters);
        }

        if ($this->imageManager->isImage($file->getMimeType()) === false) {
            throw new DocumentMimeTypeException($file->getMimeType());
        }

        $realEstatePicture->setTitle($file->getName());
        $realEstatePictureFile = $this->createRealEstateFile($file, $idAuthor, RealEstatePictureFile::$sizeNameSource);
        $realEstatePicture->addFile($realEstatePictureFile);

        $resizedFiles = $this->getFilesFromFilters($file);

        $pictures = [];

        foreach ($resizedFiles as $filterName => $resizedFile) {
            $pictureResized = $this->createRealEstateFile($resizedFile, $idAuthor, $filterName);
            $pictureResized->getDocumentObject()->setOriginalName($file->getName());
            $realEstatePicture->addFile($pictureResized);
            $pictures[] = $pictureResized;
        }

        return $realEstatePicture;
    }

    /**
     * @param RealEstatePicture $picture
     *
     * @return null|string
     */
    public function getLink(RealEstatePicture $picture)
    {
        $defaultFilter = (self::$defaultFilter ? self::$defaultFilter : 'source');

        /**
         * @var RealEstatePictureFile $file
         */
        foreach ($picture->getFiles() as $file) {
            if ($defaultFilter === $file->getSizeName()) {
                return $this->getPublicBaseUrl().'/'.$file->getDocumentObject()->getFullName();
            }
        }

        return null;
    }

    /**
     * @param RealEstatePicture $realEstatePicture
     * @param boolean           $force
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(RealEstatePicture $realEstatePicture, $force = false)
    {
        /**
         * @var RealEstatePictureFile $realEstatePictureFile
         */
        foreach ($realEstatePicture->getFiles() as $realEstatePictureFile) {
            try {
                return $this->deleteFromEntity($realEstatePictureFile->getDocumentObject());
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
     * @return RealEstatePictureFile
     */
    private function createRealEstateFile(ImageFile $file, $idAuthor, $filterName)
    {
        $documentObject = $this->createDocumentObject($file, $idAuthor);
        $realEstatePictureFile = new RealEstatePictureFile();
        $realEstatePictureFile
            ->setHeight($file->getHeight())
            ->setWidth($file->getWidth())
            ->setSizeName($filterName)
            ->setDocumentObject($documentObject);

        return $realEstatePictureFile;
    }
}
