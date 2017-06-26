<?php

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="RPGBundle\Repository\PlayerRepository")
 */
class Player
{
    const LEVEL_XP_MULTIPLIER = 1000;
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="xp", type="integer")
     */
    private $xp = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="next_level_xp_needed", type="integer")
     */
    private $nextLevelXpNeeded = self::LEVEL_XP_MULTIPLIER;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="multiplier", type="integer")
     */
    private $multiplier = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="health", type="integer")
     */
    private $health = 10;

    /**
     * @var int
     *
     * @ORM\Column(name="max_health", type="integer")
     */
    private $maxHealth = 10;

    /**
     * @var int
     *
     * @ORM\Column(name="attack_points", type="integer")
     */
    private $attackPoints = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="skill_points", type="integer")
     */
    private $skillPoints = 0;

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

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): Player
    {
        $this->token = $token;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): Player
    {
        $this->level = $level;

        return $this;
    }

    public function getXp(): int
    {
        return $this->xp;
    }

    public function setXp(int $xp): Player
    {
        $this->xp = $xp;

        return $this;
    }

    public function addXp(int $xp): Player
    {
        $this->xp += $xp;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): Player
    {
        $this->score = $score;

        return $this;
    }

    public function getMultiplier(): int
    {
        return $this->multiplier;
    }

    public function setMultiplier(int $multiplier): Player
    {
        $this->multiplier = $multiplier;

        return $this;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setHealth(int $health): Player
    {
        $this->health = $health;

        return $this;
    }

    public function getHit(int $damage): void
    {
        $this->health -= $damage;
    }

    public function getAttackPoints(): int
    {
        return $this->attackPoints;
    }

    public function setAttackPoints(int $attackPoints): Player
    {
        $this->attackPoints = $attackPoints;

        return $this;
    }

    public function getNextLevelXpNeeded(): int
    {
        return $this->nextLevelXpNeeded;
    }

    public function setNextLevelXpNeeded(int $nextLevelXpNeeded): Player
    {
        $this->nextLevelXpNeeded = $nextLevelXpNeeded;

        return $this;
    }

    public function getSkillPoints(): int
    {
        return $this->skillPoints;
    }

    public function setSkillPoints(int $skillPoints): Player
    {
        $this->skillPoints = $skillPoints;

        return $this;
    }

    public function hasLeveledUp(): bool
    {
        return $this->xp >= $this->nextLevelXpNeeded;
    }

    public function levelUp(): Player
    {
        $this->level++;
        $this->skillPoints++;
        $this->nextLevelXpNeeded = $this->level * $this->level * self::LEVEL_XP_MULTIPLIER;
        $this->maxHealth += ($this->maxHealth / 2);
        $this->health = $this->maxHealth;

        return $this;
    }

    public function addAttack(): void
    {
        $this->attackPoints += 1;
        $this->skillPoints -= 1;
    }

    public function addMultiplier(): void
    {
        $this->multiplier += 1;
        $this->skillPoints -= 1;
    }

    public function getMaxHealth(): int
    {
        return $this->maxHealth;
    }

    public function setMaxHealth(int $maxHealth): Player
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }
}
