<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 11:45
 */

namespace Iad\Bundle\FilerTechBundle\Entity;


use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\MappedSuperclass
 *
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
interface PictureInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return Picture
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param mixed $title
     * @return Picture
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getRank();

    /**
     * @param mixed $rank
     * @return Picture
     */
    public function setRank($rank);
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