<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Model\Binary;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

/**
 * Class ImageManager
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
     * @param Binary           $binary
     * @param ResizeParameters $params
     * @return string
     */
    public function filter(Binary $binary, ResizeParameters $params)
    {
        $filteredBinary = $this->filterManager->applyFilter($binary, $params->getFilter(), $params->getFilterRuntimeConfig());

        return $filteredBinary->getContent();
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
}
