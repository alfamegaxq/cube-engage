<?php

namespace RPGBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class LevelUpEvent extends Event
{
    const NAME = 'level.up';
}
