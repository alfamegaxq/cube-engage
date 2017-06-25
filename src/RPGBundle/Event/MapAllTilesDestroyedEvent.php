<?php

namespace RPGBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MapAllTilesDestroyedEvent extends Event
{
    const NAME = 'map.destroyed';
}
