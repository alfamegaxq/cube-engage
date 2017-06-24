<?php

namespace RPGBundle\Service;

use RPGBundle\Entity\Player;

class PlayerService
{
    public function createPlayer(string $username, string $type): Player
    {
        $player = new Player();
        $player->setName($username)
            ->setType($type);

        return $player;
    }
}
