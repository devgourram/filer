<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 02/10/18
 * Time: 08:57
 */

namespace Iad\Bundle\FilerTechBundle\Entity;

interface DocumentInterface
{
    /**
     * @return UploadedFile
     */
    public function getOriginalFile();

    /**
     * @param UploadedFile $originalFile
     * @return Picture
     */
    public function setOriginalFile($originalFile);
}
