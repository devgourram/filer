<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\CoreBundle\Entity\Validation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Avatar
 *
 * @ORM\Table(name="filer_avatar")
 * @ORM\Entity
 *
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
class Avatar
{
    use TimestampableEntity;

    const STATUS_ENABLED   = 'enabled';
    const STATUS_DISABLED  = 'disabled';
    const STATUS_PENDING   = 'pending';
    const STATUS_REFUSED   = 'refused';
    const STATUS_CANCELED  = 'canceled';

    private static $availableStatus = [
        self::STATUS_ENABLED,
        self::STATUS_DISABLED,
        self::STATUS_PENDING,
        self::STATUS_REFUSED,
        self::STATUS_CANCELED,
    ];

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Length(max="64")
     * @ORM\Column(name="avatar_status", type="string", length=64)
     */
    private $status;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Iad\Bundle\FilerTechBundle\Entity\AvatarFile",
     *     mappedBy="avatar",
     *     cascade={"persist", "remove"}
     * )
     */
    private $avatarFiles;

    /**
     * @var mixed $originalFile
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypesMessage = "iad_filer.validation.realEstate.pictures.size",
     *     mimeTypes = {"image/gif", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "iad_filer.validation.realEstate.pictures.type",
     * )
     */
    private $originalFile;

    /**
     * @var AvatarValidation
     *
     * @ORM\OneToMany(targetEntity="Iad\Bundle\FilerTechBundle\Entity\AvatarValidation", mappedBy="avatar", cascade={ "persist", "remove"}, orphanRemoval=true )
     */
    private $avatarValidations;

    /**
     * Avatar constructor.
     */
    public function __construct()
    {
        $this->avatarFiles = new ArrayCollection();
        $this->avatarValidations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Avatar
     */
    public function setStatus($status)
    {
        if (in_array($status, self::$availableStatus) === false) {
            throw new \InvalidArgumentException(sprintf('Invalid status given <%s>', $status));
        }
        $this->status = $status;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAvatarFiles()
    {
        return $this->avatarFiles;
    }

    /**
     * @param ArrayCollection $avatarFiles
     *
     * @return Avatar
     */
    public function setAvatarFiles(ArrayCollection $avatarFiles)
    {
        $this->avatarFiles = $avatarFiles;

        return $this;
    }

    /**
     * @param AvatarFile $avatarFile
     *
     * @return $this
     */
    public function addAvatarFile(AvatarFile $avatarFile)
    {
        if ($this->avatarFiles->contains($avatarFile) === false) {
            if ($avatarFile->getAvatar() === null) {
                $avatarFile->setAvatar($this);
            }
            $this->avatarFiles->add($avatarFile);
        }

        return $this;
    }

    /**
     * @param AvatarFile $avatarFile
     *
     * @return $this
     */
    public function removeAvatarFile(AvatarFile $avatarFile)
    {
        if ($this->avatarFiles->contains($avatarFile) === true) {
            $this->avatarFiles->removeElement($avatarFile);
        }

        return $this;
    }

    /**
     * @param string $sizeName
     *
     * @return AvatarFile
     */
    public function getAvatarFile($sizeName)
    {
        /** @var AvatarFile $avatarFile */
        foreach ($this->avatarFiles as $avatarFile) {
            if ($avatarFile->getSizeName() === $sizeName) {
                return $avatarFile;
            }
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getOriginalFile()
    {
        return $this->originalFile;
    }

    /**
     * @param mixed $originalFile
     * @return Avatar
     */
    public function setOriginalFile($originalFile)
    {
        $this->originalFile = $originalFile;

        return $this;
    }

    /**
     * GET  AvatarValidations
     *
     * @return ArrayCollection
     */
    public function getAvatarValidations()
    {
        return $this->avatarValidations;
    }

    /**
     * SET AvatarValidations
     *
     * @param ArrayCollection $avatarValidations
     *
     * @return $this
     */
    public function setAvatarValidations(Collection $avatarValidations)
    {
        $this->avatarValidations = $avatarValidations;

        return $this;
    }

    /**
     * ADD AvatarValidation
     *
     * @param AvatarValidation $avatarValidation
     *
     * @return $this
     */
    public function addAvatarValidation(AvatarValidation $avatarValidation)
    {
        $avatarValidation = $this->findAvatarValidationByValidation($avatarValidation->getValidation());

        if ($avatarValidation) {
            $avatarValidation
                ->setValue($avatarValidation->getValue())
                ->setComment($avatarValidation->getComment());
        } elseif (!$this->avatarValidations->contains($avatarValidation)) {
            $this->avatarValidations->add($avatarValidation);
        }

        return $this;
    }

    /**
     * REMOVE AvatarValidation
     *
     * @param AvatarValidation $avatarValidation
     *
     * @return $this
     */
    public function removeAvatarValidation(AvatarValidation $avatarValidation)
    {
        $this->avatarValidations->removeElement($avatarValidation);

        return $this;
    }

    /**
     * GET Validations
     *
     * @return ArrayCollection
     */
    public function getValidations()
    {
        $validations = new ArrayCollection();

        /** @var AvatarValidation $avatarValidations */
        foreach ($this->avatarValidations as $avatarValidations) {
            $validations->add($avatarValidations->getValidation());
        }

        return $validations;
    }

    /**
     * ADD Validation
     *
     * @param Validation $validation
     * @param bool       $value
     * @param null       $comment
     *
     * @return $this
     */
    public function addValidation(Validation $validation, $value = false, $comment = null)
    {
        $avatarValidation = $this->findAvatarValidationByValidation($validation);

        if (empty($avatarValidation)) {
            $avatarValidation = new AvatarValidation($this, $validation);
        }

        $avatarValidation
            ->setValue($value)
            ->setComment($comment);

        $this->addAvatarValidation($avatarValidation);

        return $this;
    }

    /**
     * REMOVE Validation
     *
     * @param Validation $validation
     *
     * @return $this
     */
    public function removeValidation(Validation $validation)
    {
        $avatarValidation = $this->findAvatarValidationByValidation($validation);

        if (!empty($avatarValidation)) {
            $this->removeAvatarValidation($avatarValidation);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getModerationArrayValues()
    {
        $data = [];
        /** @var AvatarValidation $avatarValidation */
        foreach ($this->getAvatarValidations() as $avatarValidation) {
            $data[$avatarValidation->getValidation()->getLabel()] = $avatarValidation->getValue();
        }

        return $data;
    }

    /**
     * Get File by sizeName
     *
     * @param string $sizeName
     *
     * @return AvatarFile|null
     */
    public function getFileBySizeName($sizeName)
    {
        /** @var AvatarFile $file */
        foreach ($this->avatarFiles as $file) {
            if ($file->getSizeName() == $sizeName) {
                return $file;
            }
        }

        return null;
    }

    /**
     * @param Validation $validation
     *
     * @return AvatarValidation
     */
    private function findAvatarValidationByValidation(Validation $validation)
    {
        /** @var AvatarValidation $avatarValidation */
        foreach ($this->avatarValidations as $avatarValidation) {
            if ($validation === $avatarValidation->getValidation()) {
                return $avatarValidation;
            }
        }

        return null;
    }
}
