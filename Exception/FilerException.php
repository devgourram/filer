<?php

namespace Iad\Bundle\FilerTechBundle\Exception;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class FilerException
 *
 * @package Iad\Bundle\FilerTechBundle\Exception
 */
class FilerException extends \Exception
{
    /**
     * @var array
     */
    protected $exceptionData;

    /**
     * {@inheritdoc}
     */
    public function __construct($message = 'Filer error', $code = 0)
    {
        parent::__construct($message, $code);

        $this->exceptionData = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getExceptionData()
    {
        return $this->exceptionData;
    }

    /**
     * @param array $exceptionData
     *
     * @return $this
     */
    public function setExceptionData(array $exceptionData)
    {
        $this->exceptionData = new ArrayCollection($exceptionData);

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function addExceptionData($data)
    {
        if (!$this->exceptionData->contains($data)) {
            $this->exceptionData->add($data);
        }

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function removeExceptionData($data)
    {
        $this->exceptionData->removeElement($data);

        return $this;
    }
}
