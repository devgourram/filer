<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AvatarFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class AvatarFiler extends AbstractFiler
{
    /**
     * @var string
     */
    protected $directoryPrefix = 'avatar/';

    /**
     * @var string
     */
    protected $documentType = 'avatar';

    /**
     * @param UploadedFile $uploadedFile
     * @param integer      $peopleId
     * @param string       $access
     * @param array        $details
     *
     * @return \Iad\Bundle\FilerTechBundle\Entity\DocumentObject
     */
    public function createFromUploadedFile(UploadedFile $uploadedFile, $peopleId, $access = 'private', $details = [])
    {
        $file           = $this->createFile($uploadedFile, $access, $details);
        $fileGaufrette  = $this->createFileGaufrette($file, $access);
        $documentObject = $this->createDocumentObject($file, $fileGaufrette, $peopleId);

        $this->documentObjectManager->persist($documentObject);
        $this->documentObjectManager->flush();

        // set file will write the file in the filesystem at this time
        $file->setFile($fileGaufrette);

        return $documentObject;
    }
}
