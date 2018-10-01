<?php

namespace Iad\Bundle\FilerTechBundle\Business\Service;

use Gaufrette\Exception\FileNotFound;
use Iad\Bundle\FilerTechBundle\Business\AbstractImageFiler;
use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException;
use Iad\Bundle\FilerTechBundle\Business\FileResource\ImageFile;
use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;
use Iad\Bundle\FilerTechBundle\Entity\Avatar;
use Iad\Bundle\FilerTechBundle\Entity\AvatarFile;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\AvatarManager;

/**
 * Class AvatarFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class AvatarFiler extends AbstractImageFiler
{
    /**
     * @var string
     */
    protected $defaultSize = 'small';

    /**
     * @var string
     */
    protected $directoryPrefix = 'avatar/';

    /**
     * @var string
     */
    protected $documentType = 'avatar';

    /**
     * @var AvatarManager
     */
    protected $avatarManager;

    /**
     * @var string
     */
    protected static $access = 'public';

    /**
     * @param Avatar         $avatar
     * @param integer        $idPeople
     * @param array          $details
     * @param CropParameters $cropParameters
     *
     * @return Avatar
     */
    public function create(Avatar $avatar, $idPeople, $details = [], CropParameters $cropParameters = null)
    {
        $avatar->setOriginalFile($this->createFile($avatar->getOriginalFile(), self::$access, $details));

        return $this->createAvatar($avatar, $idPeople, $cropParameters);
    }

    /**
     * @param mixed               $content
     * @param string              $originalName
     * @param integer             $idPeople
     * @param CropParameters|null $cropParameters
     *
     * @return Avatar
     */
    public function createFromBinary(
        $content,
        $originalName,
        $idPeople,
        CropParameters $cropParameters = null
    ) {
        $binary = $this->createBinary($content, null);
        $file = $this->createFileFromBinary($binary, self::$access);
        $file->setName($originalName);

        $avatar = new Avatar();
        $avatar->setOriginalFile($file);

        return $this->createAvatar($avatar, $idPeople, $cropParameters);
    }

    /**
     * @param Avatar  $avatar
     * @param boolean $force
     */
    public function delete(Avatar $avatar, $force)
    {
        /**
         * @var AvatarFile $avatarFile
         */
        foreach ($avatar->getAvatarFiles() as $avatarFile) {
            try {
                $this->deleteFromEntity($avatarFile->getDocumentObject());
            } catch (FileNotFound $e) {
                if (!$force) {
                    throw $e;
                }
            }
        }
    }

    /**
     * @return AvatarManager
     */
    public function getAvatarManager()
    {
        return $this->avatarManager;
    }

    /**
     * @param Avatar $avatar
     * @param string $filter
     *
     * @return null|string
     */
    public function getLink(Avatar $avatar, $filter = null)
    {
        if (!$filter) {
            $filter = $this->defaultSize;
        }
        /**
         * @var AvatarFile $file
         */
        foreach ($avatar->getAvatarFiles() as $file) {
            if ($filter === $file->getSizeName()) {
                return $this->getPublicBaseUrl().'/'.$file->getDocumentObject()->getFullName();
            }
        }

        return null;
    }


    /**
     * @param Avatar $avatar
     * @param string $filter
     *
     * @return null|DocumentObject
     */
    public function getFileInfo(Avatar $avatar, $filter = null)
    {
        if (!$filter) {
            $filter = $this->defaultSize;
        }
        /**
         * @var AvatarFile $file
         */
        foreach ($avatar->getAvatarFiles() as $file) {
            if ($filter === $file->getSizeName()) {
                return $file->getDocumentObject();
            }
        }

        return null;
    }

    /**
     * @param AvatarManager $avatarManager
     *
     * @return AvatarFiler
     */
    public function setAvatarManager($avatarManager)
    {
        $this->avatarManager = $avatarManager;
        $this->entityManager = $avatarManager->getManager();

        return $this;
    }

    /**
     * @param ImageFile $file
     * @param integer   $idPeople
     * @param string    $filterName
     *
     * @return AvatarFile
     */
    public function createAvatarFile(ImageFile $file, $idPeople, $filterName)
    {
        $documentObject = $this->createDocumentObject($file, $idPeople);
        $avatarFile     = new AvatarFile();
        $avatarFile
            ->setHeight($file->getHeight())
            ->setWidth($file->getWidth())
            ->setSizeName($filterName)
            ->setDocumentObject($documentObject);

        return $avatarFile;
    }

    /**
     * @param Avatar              $avatar
     * @param integer             $idPeople
     * @param CropParameters|null $cropParameters
     *
     * @return Avatar
     * @throws DocumentMimeTypeException
     */
    private function createAvatar(Avatar $avatar, $idPeople, CropParameters $cropParameters = null)
    {
        $file = $avatar->getOriginalFile();

        if ($cropParameters) {
            $file = $this->cropFile($file, $cropParameters);
        }

        if ($this->imageManager->isImage($file->getMimeType()) === false) {
            throw new DocumentMimeTypeException($file->getMimeType());
        }

        $avatar->setStatus(Avatar::STATUS_PENDING);
        $avatarFile = $this->createAvatarFile($file, $idPeople, self::SIZE_NAME_SOURCE);
        $avatar->addAvatarFile($avatarFile);

        $newFiles     = $this->getFilesFromFilters($file);
        $originalName = $avatarFile->getDocumentObject()->getOriginalName() ? $avatarFile->getDocumentObject(
        )->getOriginalName() : $file->getFullName();
        foreach ($newFiles as $filterName => $newFile) {
            $avatarFileResized = $this->createAvatarFile($newFile, $idPeople, $filterName);
            $avatarFileResized->getDocumentObject()->setOriginalName($originalName);
            $avatar->addAvatarFile($avatarFileResized);
        }

        return $avatar;
    }
}
