<?php

namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Player;
use Symfony\Component\HttpFoundation\Session\Session;

class PlayerService
{
    const AMOUNT_XP_FOR_TILE_DESTROYED = 1000;

    /** @var Session */
    private $session;
    /** @var EntityManager */
    private $em;
    /** @var Player */
    private $player;

    public function __construct(Session $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function getActivePlayer(): Player
    {
        if (!$this->player) {
            $token = $this->session->get('apiToken');
            $this->player = $this->em->getRepository('RPGBundle:Player')->findOneBy(['token' => $token]);
        }

        return $this->player;
    }

    public function createPlayer(string $username, string $type): Player
    {
        $player = new Player();
        $player->setName($username)
            ->setType($type);

        return $player;
    }

    public function gainXpFromDestroyedTile(): Player
    {
        $activePlayer = $this->getActivePlayer();
        //@TODO check if not level up
        $activePlayer->addXp(self::AMOUNT_XP_FOR_TILE_DESTROYED);
        $this->em->persist($activePlayer);
        $this->em->flush($activePlayer);

        return $activePlayer;
    }
}
