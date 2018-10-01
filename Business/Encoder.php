<?php

namespace Iad\Bundle\FilerTechBundle\Business;

/**
 * Class Encoder
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class Encoder implements EncoderInterface
{
    /**
     * @var string
     */
    protected $algo;

    /**
     * @param string $algo
     */
    public function __construct($algo = 'sha256')
    {
        $this->algo = $algo;
    }

    /**
     * {@inheritdoc}
     */
    public function hash($content)
    {
        return hash($this->algo, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function uuid($content)
    {
        return $this->hash($content.microtime());
    }
}
