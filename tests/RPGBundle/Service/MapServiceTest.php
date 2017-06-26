<?php

namespace Tests\RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use RPGBundle\Entity\Player;
use RPGBundle\Event\MapAllTilesDestroyedEvent;
use RPGBundle\Event\MapTileDestroyedEvent;
use RPGBundle\Service\MapService;
use RPGBundle\Service\PlayerService;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MapServiceTest extends TestCase
{
    /** @var EventDispatcher|PHPUnit_Framework_MockObject_MockObject */
    private $eventDispatcherMock;
    /** @var PlayerService|PHPUnit_Framework_MockObject_MockObject */
    private $playerServiceMock;
    /** @var EntityManager|PHPUnit_Framework_MockObject_MockObject */
    private $entityManagerMock;

    public function setUp()
    {
        $this->eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->playerServiceMock = $this->getMockBuilder(PlayerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @dataProvider mapDataProvider */
    public function testGenerateMap(int $level)
    {
        $mapService = $this->mockMapService();
        $map = $mapService->generateMap($level);
        $this->assertEquals($level, count($map));
        foreach ($map as $row) {
            $this->assertEquals($level, count($row));
            foreach ($row as $cell) {
                $this->assertTrue($cell >= 1 && $cell <= $level * 2);
            }
        }
    }

    public function mapDataProvider(): \Generator
    {
        yield [1];
        yield [6];
    }

    public function testInvalidMapLevel()
    {
        $mapService = $this->mockMapService();
        $this->expectException(\InvalidArgumentException::class);
        $mapService->generateMap(-1);
    }

    public function testHitTile()
    {
        $this->eventDispatcherMock
            ->expects($this->exactly(2))
            ->method('dispatch')
            ->withConsecutive(
                [$this->equalTo(MapTileDestroyedEvent::NAME)],
                [$this->equalTo(MapAllTilesDestroyedEvent::NAME)]
            )
            ->willReturn(null);

        $playerMock = new Player();

        $this->playerServiceMock
            ->expects($this->once())
            ->method('getActivePlayer')
            ->willReturn($playerMock);

        $mapService = $this->mockMapService();

        $map = $mapService->hitTile([[1]], 0, 0);
        $this->assertEquals([[0]], $map);
    }

    private function mockMapService(): MapService
    {
        return new MapService($this->eventDispatcherMock, $this->playerServiceMock, $this->entityManagerMock);
    }
}
