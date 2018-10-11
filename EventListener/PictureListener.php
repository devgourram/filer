<?php
namespace Iad\Bundle\FilerTechBundle\EventListener;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Iad\Bundle\FilerTechBundle\Business\Service\PictureFiler;
use Iad\Bundle\FilerTechBundle\Entity\BasePicture;

/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 10/10/18
 * Time: 11:37
 */

class PictureListener
{
    /**
     * @var PictureFiler $filer
     */
    private $filer;

    public function __construct(PictureFiler $filer)
    {
        $this->filer = $filer;
    }

    public function prePersist(BasePicture $picture, LifecycleEventArgs $event)
    {
        $picture = $this->filer->create($picture, -1);
    }
}