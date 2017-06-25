<?php

namespace RPGBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MapTileDestroyedEvent extends Event
{
    const NAME = 'map.tile.destroyed';
}
