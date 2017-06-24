<?php

namespace Tests\RPGBundle\Service;

use PHPUnit\Framework\TestCase;
use RPGBundle\Entity\Player;
use RPGBundle\Service\PlayerService;

class PlayerServiceTest extends TestCase
{
    /** @var PlayerService */
    private $playerService;

    public function setUp()
    {
        $this->playerService = new PlayerService();
    }
    
    public function testCreatePlayer()
    {
        $createdPlayer = $this->playerService->createPlayer('username', Player::TYPE_BLACK);
        $this->assertInstanceOf(Player::class, $createdPlayer);
        $this->assertEquals('username', $createdPlayer->getName());
        $this->assertEquals(Player::TYPE_BLACK, $createdPlayer->getType());
    }
}
