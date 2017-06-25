<?php

namespace Tests\RPGBundle\Service;

use PHPUnit\Framework\TestCase;
use RPGBundle\Service\MapService;

class MapServiceTest extends TestCase
{
    /** @var MapService */
    private $mapService;

    public function setUp()
    {
        $this->mapService = new MapService();
    }

    /** @dataProvider mapDataProvider */
    public function testGenerateMap(int $level)
    {
        $map = $this->mapService->generateMap($level);
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
        $this->expectException(\InvalidArgumentException::class);
        $this->mapService->generateMap(-1);
    }
}
