<?php

namespace RPGBundle\EventListener;

use RPGBundle\Service\PlayerService;

class MapTileDestroyedEventListener
{
    /** @var PlayerService */
    private $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function onTileDestroyed(): void
    {
        $this->playerService->gainXpFromDestroyedTile();
    }
}
