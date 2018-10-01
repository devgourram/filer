<?php
namespace Iad\Bundle\FilerTechBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Iad\Bundle\CoreBundle\Entity\Validation;

/**
 * Class AvatarValidation
 * @ORM\Entity()
 * @ORM\Table(name="filer_avatar_validation")
 */
class AvatarValidation
{
    /**
     * @var Avatar
     *
     * @ORM\ManyToOne(targetEntity="Iad\Bundle\FilerTechBundle\Entity\Avatar", inversedBy="avatarValidations")
     * @ORM\JoinColumn(name="avatar_id", nullable=false)
     * @ORM\Id
     */
    protected $avatar;

    /**
     * @var Validation
     *
     * @ORM\ManyToOne(targetEntity="Iad\Bundle\CoreBundle\Entity\Validation")
     * @ORM\JoinColumn(name="validation_id", nullable=false)
     * @ORM\Id
     */
    protected $validation;

    /**
     * @var bool
     * @ORM\Column(name="value", type="boolean", nullable=true, options={"default": false})
     */
    protected $value;

    /**
     * @var string
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    protected $comment;

    /**
     * AvatarValidation constructor.
     * @param Avatar     $avatar
     * @param Validation $validation
     */
    public function __construct(Avatar $avatar, Validation $validation)
    {
        $this->avatar = $avatar;
        $this->validation = $validation;
    }

    /**
     * GET  Validation
     *
     * @return Validation
     */
    public function getValidation()
    {
        return $this->validation;
    }


    /**
     * SET Validation
     *
     * @param Validation $validation
     *
     * @return $this
     */
    public function setValidation(Validation $validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * GET  Avatar
     *
     * @return Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * SET Avatar
     *
     * @param Avatar $avatar
     *
     * @return $this
     */
    public function setAvatar(Avatar $avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     *  IS  Value
     *
     * @return bool
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * SET Value
     *
     * @param bool $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * GET  Comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * SET Comment
     *
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }
}
