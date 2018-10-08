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
     * @var PictureManagerInterface
     */
    protected $pictureManager;

    /**
     * @var string
     */
    protected static $access = 'public';

    /**
     * @var string
     */
    protected static $defaultFilter = 'high';

    protected  $class;
    
    
    public function __construct(DocumentManagerInterface $pictureManager)
    {
        $this->pictureManager = $pictureManager;
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
        $pictureFile = $this->createPictureFile($file, $idAuthor, PictureFile::$sizeNameSource, $picture);
        $picture->addFile($pictureFile);

        $resizedFiles = $this->getFilesFromFilters($file, $picture);

        $pictures = [];

        foreach ($resizedFiles as $filterName => $resizedFile) {
            $pictureResized = $this->createPictureFile($resizedFile, $idAuthor, $filterName, $picture);
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
    private function createPictureFile(ImageFile $file, $idAuthor, $filterName, Picture $picture)
    {
        $documentObject = $this->createDocumentObject($file, $idAuthor);
        $classFile = $this->configurations[get_class($picture)]->getFilerClass();
        $pictureFile = new $classFile();
        $pictureFile
            ->setHeight($file->getHeight())
            ->setWidth($file->getWidth())
            ->setSizeName($filterName)
            ->setDocumentObject($documentObject);

        return $pictureFile;
    }


}