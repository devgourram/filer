<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 11:46
 */

namespace Iad\Bundle\FilerTechBundle\Entity;


/**
 *
 * Interface PictureFileInterface
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
interface PictureFileInterface
{
    public function setPicture(PictureInterface $picture);
}