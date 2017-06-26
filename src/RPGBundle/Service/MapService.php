<?php

namespace RPGBundle\Service;

use InvalidArgumentException;
use RPGBundle\Event\MapAlltilesDestroyed;
use RPGBundle\Event\MapAllTilesDestroyedEvent;
use RPGBundle\Event\MapTileDestroyedEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MapService
{
    /** @var  EventDispatcher */
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function generateMap(int $level): array
    {
        if ($level < 1) {
            throw new InvalidArgumentException();
        }

        $map = [];
        for ($i = 0; $i < $level; $i++) {
            $row = [];
            for ($j = 0; $j < $level; $j++) {
                $row[] = rand(1, $level);
            }
            $map[] = $row;
        }

        return $map;
    }

    public function hitTile(array $map, int $row, int $column): array
    {
        if (isset($map[$row][$column]) && $map[$row][$column] != 0) {
            $map[$row][$column] -= 1;
            $this->checkIfTileDestroyed($map, $row, $column);
            $count = $this->countZerosInMap($map);
            $this->checkIfMapDestroyed($map, $count);
        }

        return $map;
    }

    private function checkIfMapDestroyed(array $map, int $count): void
    {
        $halfTiles = pow(count($map), 2) / 2;
        if ($count >= $halfTiles) {
            $this->dispatcher->dispatch(MapAlltilesDestroyedEvent::NAME);
        }
    }

    private function checkIfTileDestroyed(array $map, int $row, int $column): void
    {
        if ($map[$row][$column] === 0) {
            $this->dispatcher->dispatch(MapTileDestroyedEvent::NAME);
        }
    }

    private function countZerosInMap(array $map): int
    {
        $count = 0;
        array_walk_recursive($map, function ($item, $key) use (&$count) {
            if ($item === 0) {
                $count++;
            }
        });

        return $count;
    }
}
