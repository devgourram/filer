<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ResizeParameters
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class ResizeParameters
{
    const MODE_INSET    = 'inset';
    const MODE_OUTBOUND = 'outbound';

    const DISPOSITION_ATTACHMENT = 'attachment';
    const DISPOSITION_INLINE     = 'inline';

    /**
     * @Assert\Type(
     *   type="string",
     *   message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    protected $filter;

    /**
     * @Assert\Collection(
     *   fields = {
     *     "width" = @Assert\Type(
     *       type="string"
     *     ),
     *     "height" = @Assert\Type(
     *       type="string"
     *     ),
     *   },
     *   allowMissingFields = false
     * )
     */
    protected $size;

    /**
     * @Assert\Type(
     *   type="integer",
     *   message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Range(
     *   min = 0,
     *   max = 100,
     *   minMessage = "You must be at least {{ limit }}% of quality",
     *   maxMessage = "You cannot be taller than {{ limit }}% of quality"
     * )
     */
    protected $quality;

    /**
     * @Assert\Choice(choices = {"inset", "outbound"}, message = "Choose a valid mode: inset, outbound.")
     */
    protected $mode;

    /**
     * @Assert\Choice(choices = {"attachment", "inline"}, message = "Choose a valid disposition: attachment, inline.")
     */
    protected $disposition;

    /**
     * Construct
     */
    public function __construct($filter, $size)
    {
        $this->filter  = $filter;
        $this->size    = $size;
        $this->quality = 70;
        $this->mode    = 'inset';
    }

    /**
     * @return array
     */
    public function getFilterRuntimeConfig()
    {
        if ($this->size !== null && count($this->size) == 2) {
            $runTimeConfig = [
                'quality' => (int) $this->quality,
                'filters' => [
                    'thumbnail' => [
                        'size' => array_values($this->size),
                        'mode' => $this->mode,
                    ],
                ],
            ];

            return $runTimeConfig;
        }

        return [];
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param mixed $filter
     * @return $this
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     * @return $this
     */
    public function setQuality($quality)
    {
        if ($quality > 0) {
            $this->quality = $quality;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisposition()
    {
        return $this->disposition;
    }

    /**
     * @param mixed $disposition
     * @return $this
     */
    public function setDisposition($disposition)
    {
        $this->disposition = $disposition;

        return $this;
    }
}
