<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 05/10/18
 * Time: 09:48
 */

namespace Iad\Bundle\FilerTechBundle\Business\Service;

/**
 * Class FilerConfiguration
 * @package Iad\Bundle\FilerTechBundle\Business\Service
 */

class FilerConfiguration
{
    /**
     * @var string $directoryPrefix
     */
    protected $directoryPrefix;

    /**
     * @var string $documentType
     */
    protected $documentType;

    /**
     * @var array $resizingFilters
     */
    protected $resizingFilters = [];

    /**
     * @var string $waterMarkFilter
     */
    protected $waterMarkFilter = null;

    /**
     * @var string $class
     */
    protected $class;

    /**
     * @var string $class
     */
    protected $filerClass;

    /**
     * FilerConfiguration constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getDirectoryPrefix()
    {
        return $this->directoryPrefix;
    }

    /**
     * @param string $directoryPrefix
     * @return FilerConfiguration
     */
    public function setDirectoryPrefix($directoryPrefix)
    {
        $this->directoryPrefix = $directoryPrefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * @param string $documentType
     * @return FilerConfiguration
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @return array
     */
    public function getResizingFilters()
    {
        return $this->resizingFilters;
    }

    /**
     * @param array $resizingFilters
     * @return FilerConfiguration
     */
    public function setResizingFilters($resizingFilters)
    {
        $this->resizingFilters = $resizingFilters;
        return $this;
    }

    /**
     * @return string
     */
    public function getWaterMarkFilter()
    {
        return $this->waterMarkFilter;
    }

    /**
     * @param string $waterMarkFilter
     * @return FilerConfiguration
     */
    public function setWaterMarkFilter($waterMarkFilter)
    {
        $this->waterMarkFilter = $waterMarkFilter;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return FilerConfiguration
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilerClass()
    {
        return $this->filerClass;
    }

    /**
     * @param string $filerClass
     */
    public function setFilerClass($filerClass)
    {
        $this->filerClass = $filerClass;
    }


    public static function createConfiguration(array $config)
    {
        $configurator = new FilerConfiguration();

        if (isset($config['resizing_filters'])) {
            $configurator->setResizingFilters($config['resizing_filters']);
        }

        if (isset($config['watermark_filter'])) {
            $configurator->setWaterMarkFilter($config['watermark_filter']);
        }

        if (isset($config['document_type'])) {
            $configurator->setDocumentType($config['document_type']);
        }

        if (isset($config['directory_prefix'])) {
            $configurator->setDirectoryPrefix($config['directory_prefix']);
        }

        if (isset($config['class'])) {
            $configurator->setClass($config['class']);
        }

        if (isset($config['class_file'])) {
            $configurator->setFilerClass($config['class_file']);
        }


        return $configurator;
    }


}