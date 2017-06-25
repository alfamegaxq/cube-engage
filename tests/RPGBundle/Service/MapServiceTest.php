<?php

namespace Tests\RPGBundle\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use RPGBundle\Event\MapAllTilesDestroyedEvent;
use RPGBundle\Event\MapTileDestroyedEvent;
use RPGBundle\Service\MapService;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MapServiceTest extends TestCase
{
    /** @var EventDispatcher|PHPUnit_Framework_MockObject_MockObject */
    private $eventDispatcherMock;

    public function setUp()
    {
        $this->eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->disableOriginalConstructor()
            ->getMock();

    }

    /** @dataProvider mapDataProvider */
    public function testGenerateMap(int $level)
    {
        $mapService = $this->mockMapService($this->eventDispatcherMock);
        $map = $mapService->generateMap($level);
        $this->assertEquals($level, count($map));
        foreach ($map as $row) {
            $this->assertEquals($level, count($row));
            foreach ($row as $cell) {
                $this->assertTrue($cell >= 1 && $cell <= $level);
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
        $mapService = $this->mockMapService($this->eventDispatcherMock);
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

        $mapService = $this->mockMapService($this->eventDispatcherMock);

        $map = $mapService->hitTile([[1]], 0, 0);
        $this->assertEquals([[0]], $map);
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject|EventDispatcher $eventDispatcherMock
     * @return MapService
     */
    private function mockMapService($eventDispatcherMock): MapService
    {
        return new MapService($eventDispatcherMock);
    }
}
