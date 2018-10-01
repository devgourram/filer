<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 12:01
 */

namespace Iad\Bundle\FilerTechBundle\Manager;

interface PictureManagerInterface
{
    /**
     * {@inheritDoc}
     */
    public function getClass();

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\PictureRepository
     */
    public function getRepository();
}