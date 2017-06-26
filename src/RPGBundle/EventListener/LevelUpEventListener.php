<?php

namespace RPGBundle\EventListener;

use RPGBundle\Service\PlayerService;

class LevelUpEventListener
{
    /** @var PlayerService */
    private $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function onLevelUp(): void
    {
        $this->playerService->levelUp();
    }
}
