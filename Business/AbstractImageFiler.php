<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\FileResource\ImageFile;
use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface FilerInterface
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
abstract class AbstractImageFiler extends AbstractFiler
{
    const SIZE_NAME_SOURCE = "source";

    /**
     * @var ImageManager $imageManager
     */
    protected $imageManager;

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * @param ImageManager $imageManager
     *
     * @return AbstractFiler
     */
    public function setImageManager($imageManager)
    {
        $this->imageManager = $imageManager;

        return $this;
    }

    /**
     * @param string $filter
     * @return bool
     */
    public function isFilterExist($filter)
    {
        return in_array($filter, $this->resizingFilters);
    }

    /**
     * @param BinaryInterface $binary
     * @param string          $access
     *
     * @return File
     */
    public function createFileFromBinary(BinaryInterface $binary, $access)
    {
        $content = getimagesizefromstring($binary->getContent());
        list($width, $height) = $content;

        $file = $this->setFileFromBinary(new ImageFile(), $binary, $access);
        $file->setWidth($width)
            ->setHeight($height)
            ->setMimeType($content["mime"]);

        return $file;
    }

    /**
     * @param ImageFile $file
     *
     * @return ImageFile[]
     */
    protected function getFilesFromFilters(ImageFile $file, $picture)
    {
        $resizedFiles = [];
        $binary = $this->imageManager->createBinary($file->getContent(), $file->getMimeType());
        $watermarkFilter = $this->configurations[get_class($picture)]->getWaterMarkFiler();

        foreach ($this->configurations[get_class($picture)]->getResizingFilers() as $resizeFilter) {
            $newBinary  = $this->imageManager->filter($binary, $resizeFilter);
            if ($watermarkFilter) {
                $newBinary  = $this->imageManager->filter($newBinary, $watermarkFilter);
            }
            $resizedFiles[$resizeFilter] = $this->createFileFromBinary($newBinary, $file->getAccess());
        }

        return $resizedFiles;
    }

    /**
     * @param ImageFile      $file
     * @param CropParameters $cropParams
     *
     * @return File
     */
    protected function cropFile(ImageFile $file, CropParameters $cropParams)
    {
        $this->imageManager->getFilterConfiguration()->set($cropParams->getFilter(), $cropParams->getFilterRuntimeConfig());

        $binary         = $this->imageManager->createBinary($file->getContent(), $file->getMimeType());
        $croppedBinary  = $this->imageManager->filter($binary, $cropParams->getFilter());
        $croppedFile    = $this->createFileFromBinary($croppedBinary, $file->getAccess());
        $croppedFile->setName($file->getName());

        return $croppedFile;
    }

    /**
     * @param ImageFile $file
     *
     * @return File
     */
    protected function waterMarkFile(ImageFile $file)
    {
        $binary         = $this->imageManager->createBinary($file->getContent(), $file->getMimeType());
        $croppedBinary  = $this->imageManager->filter($binary, 'watermark');
        $croppedFile    = $this->createFileFromBinary($croppedBinary, $file->getAccess());
        $croppedFile->setName($file->getName());

        return $croppedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string       $access
     * @param array        $details
     *
     * @return File
     */
    protected function createFile(UploadedFile $uploadedFile, $access, $details)
    {
        list($width, $height) = getimagesize($uploadedFile->getPathname());
        $file = $this->processFile(new ImageFile(), $uploadedFile, $access, $details);
        $file->setWidth($width)
            ->setHeight($height);

        return $file;
    }
}
