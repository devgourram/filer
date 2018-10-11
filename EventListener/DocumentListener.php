<?php
namespace Iad\Bundle\FilerTechBundle\EventListener;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Iad\Bundle\FilerTechBundle\Business\Service\DocumentFiler;
use Iad\Bundle\FilerTechBundle\Entity\BaseDocument;
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 10/10/18
 * Time: 11:37
 */

class DocumentListener
{
    /**
     * @var DocumentFiler $filer
     */
    private $filer;

    public function __construct(DocumentFiler $filer)
    {
        $this->filer = $filer;
    }

    public function prePersist(BaseDocument $document, LifecycleEventArgs $event)
    {
        $document = $this->filer->create($document, "-1");
    }
}