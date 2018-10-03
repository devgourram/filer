<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 02/10/18
 * Time: 09:03
 */

namespace Iad\Bundle\FilerTechBundle\Business\Service;


use Iad\Bundle\FilerTechBundle\Business\AbstractFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Model\DocumentInterface;

class DocumentFiler extends AbstractFiler
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
     * @var string
     */
    protected static $access = 'private';


    public function __construct(Encoder $encoder)
    {
        parent::__construct($encoder);
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
     * @return DocumentFiler
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
     * @return DocumentFiler
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @param AdministrativeDocument $administrativeDocument
     * @param integer                $authorId
     *
     * @return AdministrativeDocument
     */
    public function create(DocumentInterface $administrativeDocument, $authorId)
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
    public function delete(DocumentInterface $administrativeDocument, $force = false)
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
    public function getFile(DocumentInterface $administrativeDocument)
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
    public function getFileResponse(DocumentInterface $administrativeDocument, $disposition = 'inline')
    {
        $file = $this->createFileFromEntity($administrativeDocument->getDocumentObject());

        $response = new Response($file->getContent(), 200, [
            'content-type'        => $file->getMimeType(),
            'content-disposition' => $disposition.'; filename="'.$file->getName().'"',
        ]);

        $response->setMaxAge(3600);

        return $response;
    }

    /**
     *
     * @param AdministrativeDocument $administrativeDocument
     *
     * @return mixed
     */
    public function getLink(DocumentInterface $administrativeDocument)
    {
        return $this->router->generate(
            'iad_filer_administrative_document_download',
            ['id' => $administrativeDocument->getId()],
            true
        );
    }
}