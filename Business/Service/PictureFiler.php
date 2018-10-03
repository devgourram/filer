<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 10:33
 */

namespace Iad\Bundle\FilerTechBundle\Business\Service;


use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException;
use Iad\Bundle\FilerTechBundle\Business\FileResource\ImageFile;
use Iad\Bundle\FilerTechBundle\Model\Picture;
use Iad\Bundle\FilerTechBundle\Model\PictureFile;
use Iad\Bundle\FilerTechBundle\Manager\DocumentManagerInterface;
use Iad\Bundle\FilerTechBundle\Business\AbstractImageFiler;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class PictureFiler extends AbstractImageFiler
{
    /**
     * @var string
     */
    protected $directoryPrefix;

    /**
     * @var string
     */
    protected $documentType;

    /**
     * @var PictureManagerInterface
     */
    protected $pictureManager;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @var Encoder
     */
    protected $encoder;

    /**
     * @var string
     */
    protected static $access = 'public';

    /**
     * @var string
     */
    protected static $defaultFilter = 'high';

    protected  $class;
    
    
    public function __construct(DocumentManagerInterface $pictureManager, ImageManager $imageManager, Encoder $encoder)
    {
        $this->pictureManager = $pictureManager;
        $this->imageManager = $imageManager;
        $this->encoder = $encoder;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     * @return PictureFiler
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectoryPrefix()
    {
        return $this->directoryPrefix;
    }

    /**
     * @param string $directoryPrefix
     * @return PictureFiler
     */
    public function setDirectoryPrefix($directoryPrefix)
    {
        $this->directoryPrefix = $directoryPrefix;
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
     * @return PictureFiler
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @return DocumentManagerInterface
     */
    public function getPictureManager()
    {
        return $this->pictureManager;
    }

    /**
     * @param DocumentManagerInterface $pictureManager
     *
     * @return PictureFiler
     */
    public function setPictureManager(DocumentManagerInterface $pictureManager)
    {
        $this->pictureManager = $pictureManager;
        $this->entityManager = $pictureManager->getManager();

        return $this;
    }

    /**
     * @param Picture           $picture
     * @param integer           $idAuthor
     * @param array             $details
     * @param CropParameters    $cropParameters
     *
     * @return RealEstatePicture
     * @throws DocumentMimeTypeException
     */
    public function create(Picture $picture, $idAuthor, $details = [], CropParameters $cropParameters = null)
    {
        $file = $this->createFile($picture->getOriginalFile(), self::$access, $details);

        if ($cropParameters) {
            $file = $this->cropFile($file, $cropParameters);
        }

        if ($this->imageManager->isImage($file->getMimeType()) === false) {
            throw new DocumentMimeTypeException($file->getMimeType());
        }

        $picture->setTitle($file->getName());
        $pictureFile = $this->createPictureFile($file, $idAuthor, PictureFile::$sizeNameSource);
        $picture->addFile($pictureFile);

        $resizedFiles = $this->getFilesFromFilters($file);

        $pictures = [];

        foreach ($resizedFiles as $filterName => $resizedFile) {
            $pictureResized = $this->createPictureFile($resizedFile, $idAuthor, $filterName);
            $pictureResized->getDocumentObject()->setOriginalName($file->getName());
            $picture->addFile($pictureResized);
            $pictures[] = $pictureResized;
        }

        return $picture;
    }

    /**
     * @param Picture $picture
     *
     * @return null|string
     */
    public function getLink(Picture $picture)
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
     * @param Picture $picture
     * @param boolean           $force
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(Picture $picture, $force = false)
    {
        /**
         * @var PictureFile $pictureFile
         */
        foreach ($picture->getFiles() as $pictureFile) {
            try {
                return $this->deleteFromEntity($pictureFile->getDocumentObject());
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
     * @return PictureFile
     */
    private function createPictureFile(ImageFile $file, $idAuthor, $filterName)
    {
        $documentObject = $this->createDocumentObject($file, $idAuthor);
        $pictureFile = new $this->class();
        $pictureFile
            ->setHeight($file->getHeight())
            ->setWidth($file->getWidth())
            ->setSizeName($filterName)
            ->setDocumentObject($documentObject);

        return $pictureFile;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * @param ImageManager $imageManager
     * @return PictureFiler
     */
    public function setImageManager($imageManager)
    {
        $this->imageManager = $imageManager;
        return $this;
    }


}