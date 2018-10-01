<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Model\Binary;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

/**
 * Class ImageManager
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class ImageManager
{
    /**
     * @var FilterManager
     */
    protected $filterManager;

    /**
     * @param FilterManager $filterManager
     */
    public function __construct(FilterManager $filterManager)
    {
        $this->filterManager = $filterManager;
    }

    /**
     * @param string $mimeType
     *
     * @return integer
     */
    public function isImage($mimeType)
    {
        return (bool) preg_match('#^image/#', $mimeType);
    }

    /**
     * @param Binary $binary
     * @param string $filter
     * @param array  $runtimeConfig
     *
     * @return \Liip\ImagineBundle\Binary\BinaryInterface
     */
    public function filter(Binary $binary, $filter, $runtimeConfig = [])
    {
        $filteredBinary = $this->filterManager->applyFilter($binary, $filter, $runtimeConfig);

        return $filteredBinary;
    }

    /**
     * @param mixed  $content
     * @param string $mimeType
     * @return Binary
     */
    public function createBinary($content, $mimeType)
    {
        $extensionGuesser = ExtensionGuesser::getInstance();

        $format = $extensionGuesser->guess($mimeType);

        return new Binary(
            $content,
            $mimeType,
            $format
        );
    }

    /**
     * @return \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration
     */
    public function getFilterConfiguration()
    {
        return $this->filterManager->getFilterConfiguration();
    }

    /**
     * @param string $filter
     *
     * @return array
     */
    public function getFilterParameters($filter)
    {
        return $this->filterManager->getFilterConfiguration()->get($filter);
    }
}
