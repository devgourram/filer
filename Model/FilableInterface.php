<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 12:26
 */

namespace Iad\Bundle\FilerTechBundle\Model;


interface FilableInterface
{

    /**
     * @return mixed
     */
    public function getFiles();

    /**
     * @param mixed $files
     * @return Picture
     */
    public function setFiles($files);

    /**
     * @param PictureFileInterface $file
     *
     * @return $this
     */
    public function addFile(PictureFileInterface $file);

    /**
     * @param PictureFileInterface $file
     *
     * @return $this
     */
    public function removeFile(PictureFileInterface $file);

}