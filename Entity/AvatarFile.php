<?php
namespace Iad\Bundle\FilerTechBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Iad\Bundle\FilerTechBundle\Entity\Traits\ImageTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AvatarFile
 *
 * @ORM\Table(name="filer_avatar_file")
 * @ORM\Entity
 *
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
class AvatarFile
{
    use ImageTrait;
    use FilerTrait;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="Iad\Bundle\FilerTechBundle\Entity\Avatar", inversedBy="avatarFiles")
     * @ORM\JoinColumn(name="id_avatar", referencedColumnName="id")
     */
    private $avatar;

    /**
     * @var array
     * @ORM\Column(name="data", type="json_array", nullable=true)
     */
    private $data;

    /**
     * @return Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param Avatar $avatar
     *
     * @return AvatarFile
     */
    public function setAvatar(Avatar $avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * GET  Data
     *
     * @return array
     */
    public function getData()
    {
        return (array) $this->data;
    }

    /**
     * SET Data
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    /**
     * SET Data value
     *
     * @param string $key
     * @param mixed  $data
     *
     * @return $this
     */
    public function setDataValue($key, $data)
    {
        if (!is_array($this->data)) {
            $this->data = [];
        }

        $this->data[$key] = $data;

        return $this;
    }

    /**
     * SET Data value
     *
     * @param string $key
     *
     * @return $this
     */
    public function removeDataValue($key)
    {
        if (is_array($this->data) && isset($this->data[$key])) {
            unset($this->data[$key]);
        }

        return $this;
    }
}
