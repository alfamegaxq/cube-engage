<?php

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="RPGBundle\Repository\PlayerRepository")
 */
class Player
{
    const TYPE_RED = 'RED';
    const TYPE_BLUE = 'BLUE';
    const TYPE_BLACK = 'BLACK';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="anme", type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setType(string $type): Player
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Player
    {
        $this->name = $name;

        return $this;
    }
}
