<?php

namespace RPGBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;

class MapAllTilesDestroyedEventListener
{
    /** @var Session */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function onAllTilesDestroyed(): void
    {
        $this->session->remove('map');
    }
}
