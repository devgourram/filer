<?php

namespace Iad\Bundle\FilerTechBundle\Business\Service;

use Gaufrette\Exception\FileNotFound;
use Iad\Bundle\FilerTechBundle\Business\AbstractFiler;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Entity\AdministrativeDocument;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdministrativeDocumentFiler
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class AdministrativeDocumentFiler extends AbstractFiler
{
    /**
     * @var string
     */
    protected $directoryPrefix = 'administrative_documents/';

    /**
     * @var string
     */
    protected $documentType = 'administrative_document';

    /**
     * @var string
     */
    protected static $access = 'private';

    /**
     * @param AdministrativeDocument $administrativeDocument
     * @param integer                $authorId
     *
     * @return AdministrativeDocument
     */
    public function create(AdministrativeDocument $administrativeDocument, $authorId)
    {

        $file = $this->processFile(new File(), $administrativeDocument->getOriginalFile(), self::$access);
        $documentObject = $this->createDocumentObject($file, $authorId);
        $administrativeDocument->setDocumentObject($documentObject);

        return $administrativeDocument;
    }

    /**
     * @param AdministrativeDocument $administrativeDocument
     * @param bool                   $force
     *
     * @return bool
     */
    public function delete(AdministrativeDocument $administrativeDocument, $force = false)
    {
        try {
            return $this->deleteFromEntity($administrativeDocument->getDocumentObject());
        } catch (FileNotFound $e) {
            if (!$force) {
                throw $e;
            }
        }
    }

    /**
     * @param AdministrativeDocument $administrativeDocument
     *
     * @return File
     */
    public function getFile(AdministrativeDocument $administrativeDocument)
    {
        return $this->createFileFromEntity($administrativeDocument->getDocumentObject());
    }

    /**
     * Get Administrative Document
     *
     * @param AdministrativeDocument $administrativeDocument
     * @param string                 $disposition
     *
     * @return Response
     */
    public function getFileResponse(AdministrativeDocument $administrativeDocument, $disposition = 'inline')
    {
        $file = $this->createFileFromEntity($administrativeDocument->getDocumentObject());

        $response = new Response($file->getContent(), 200, [
            'content-type'        => $file->getMimeType(),
            'content-disposition' => $disposition.'; filename="'.$file->getName().'"',
        ]);

        $response->setMaxAge(3600);

        return $response;
    }
}
