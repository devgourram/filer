<?php

namespace Iad\Bundle\FilerTechBundle\Business\Filters;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ResizeParameters
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class CropParameters
{
    /**
     * @Assert\Type(
     *   type="string",
     *   message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    protected $filter = 'filer_crop_dyn';

    /**
     * @Assert\Collection(
     *   fields = {
     *     "width" = @Assert\Type(
     *       type="integer"
     *     ),
     *     "height" = @Assert\Type(
     *       type="integer"
     *     ),
     *   },
     *   allowMissingFields = false
     * )
     */
    protected $size;

    /**
     * @Assert\Collection(
     *   fields = {
     *     "x" = @Assert\Type(
     *       type="integer"
     *     ),
     *     "y" = @Assert\Type(
     *       type="integer"
     *     ),
     *   },
     *   allowMissingFields = false
     * )
     */
    protected $start;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->filter  = null;
        $this->size    = [0, 0];
        $this->start   = [0, 0];
    }

    /**
     * @return array
     */
    public function getFilterRuntimeConfig()
    {
        if ($this->size !== null && count($this->size) == 2) {
            $runTimeConfig = [
                'filters' => [
                    'crop' => [
                        'size' => array_values($this->size),
                        'start' => array_values($this->start),
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
     * @return [integer, integer]
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param integer $width
     * @param integer $height
     *
     * @return $this
     */
    public function setSize($width, $height)
    {
        $this->size = [$width, $height];

        return $this;
    }

    /**
     * @return [integer, integer]
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     *
     * @param integer $x
     * @param integer $y
     *
     * @return CropParameters
     */
    public function setStart($x, $y)
    {
        $this->start = [$x, $y];

        return $this;
    }
}
