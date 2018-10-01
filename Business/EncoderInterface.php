<?php

namespace Iad\Bundle\FilerTechBundle\Business;

/**
 * Interface EncoderInterface
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
interface EncoderInterface
{
    /**
     * @param mixed $content
     * @return string
     */
    public function uuid($content);

    /**
     * @param mixed $content
     * @return string
     */
    public function hash($content);
}
