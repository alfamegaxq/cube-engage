<?php

namespace Tests\RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use RPGBundle\Entity\Player;
use RPGBundle\Service\PlayerService;
use Symfony\Component\HttpFoundation\Session\Session;

class PlayerServiceTest extends TestCase
{
    /** @var PHPUnit_Framework_MockObject_MockObject|Session */
    private $sessionMock;
    /** @var PHPUnit_Framework_MockObject_MockObject|EntityManager */
    private $entityManagerMock;

    public function setUp()
    {
        $this->sessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCreatePlayer()
    {
        $playerService = $this->getPlayerServiceWithMocks();
        $createdPlayer = $playerService->createPlayer('username', Player::TYPE_BLACK);
        $this->assertInstanceOf(Player::class, $createdPlayer);
        $this->assertEquals('username', $createdPlayer->getName());
        $this->assertEquals(Player::TYPE_BLACK, $createdPlayer->getType());
    }

    public function testGainXpFromTileDestroyed()
    {
        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist');

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $this->sessionMock
            ->expects($this->once())
            ->method('get')
            ->with('apiToken')
            ->willReturn('test123');

        $repositoryMock = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $playerMock = new Player();
        $playerMock->setToken('test123')
            ->setType(Player::TYPE_RED)
            ->setName('name');

        $repositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => 'test123'])
            ->willReturn($playerMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('getRepository')
            ->with('RPGBundle:Player')
            ->willReturn($repositoryMock);

        $playerService = $this->getPlayerService($this->sessionMock, $this->entityManagerMock);
        $updatedPlayer = $playerService->gainXpFromDestroyedTile();
        $this->assertEquals(1000, $updatedPlayer->getXp());
    }

    public function getPlayerService($sessionMock, $entityManagerMock): PlayerService
    {
        return new PlayerService($sessionMock, $entityManagerMock);
    }

    public function getPlayerServiceWithMocks(): PlayerService
    {
        return new PlayerService($this->sessionMock, $this->entityManagerMock);
    }
}
