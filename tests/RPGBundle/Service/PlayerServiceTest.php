<?php

namespace Tests\RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use RPGBundle\Entity\Player;
use RPGBundle\Event\LevelUpEvent;
use RPGBundle\Service\PlayerService;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Session\Session;

class PlayerServiceTest extends TestCase
{
    /** @var PHPUnit_Framework_MockObject_MockObject|Session */
    private $sessionMock;
    /** @var PHPUnit_Framework_MockObject_MockObject|EntityManager */
    private $entityManagerMock;
    /** @var PHPUnit_Framework_MockObject_MockObject|EventDispatcher */
    private $dispatcherMock;

    public function setUp()
    {
        $this->sessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dispatcherMock = $this->getMockBuilder(EventDispatcher::class)
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

        $this->dispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with(LevelUpEvent::NAME);

        $playerService = $this->getPlayerService($this->sessionMock, $this->entityManagerMock, $this->dispatcherMock);
        $updatedPlayer = $playerService->gainXpFromDestroyedTile();
        $this->assertEquals(1000, $updatedPlayer->getXp());
    }

    public function getPlayerService($sessionMock, $entityManagerMock, $dispatcherMock): PlayerService
    {
        return new PlayerService($sessionMock, $entityManagerMock, $dispatcherMock);
    }

    public function getPlayerServiceWithMocks(): PlayerService
    {
        return new PlayerService($this->sessionMock, $this->entityManagerMock, $this->dispatcherMock);
    }

    public function testUpgradeAttack()
    {
        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist');

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $playerMock = new Player();
        $playerMock->setToken('test123')
            ->setType(Player::TYPE_RED)
            ->setName('name')
            ->setSkillPoints(1);

        $repositoryMock = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($playerMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('getRepository')
            ->with('RPGBundle:Player')
            ->willReturn($repositoryMock);

        $playerService = $this->getPlayerServiceWithMocks();
        $player = $playerService->upgradeAttack();

        $this->assertEquals(2, $player->getAttackPoints());

        $player = $playerService->upgradeAttack();

        $this->assertEquals(2, $player->getAttackPoints());
    }

    public function testUpgradeMultiplier()
    {
        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist');

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $playerMock = new Player();
        $playerMock->setToken('test123')
            ->setType(Player::TYPE_RED)
            ->setName('name')
            ->setSkillPoints(1);

        $repositoryMock = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($playerMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('getRepository')
            ->with('RPGBundle:Player')
            ->willReturn($repositoryMock);

        $playerService = $this->getPlayerServiceWithMocks();
        $player = $playerService->upgradeMultiplier();

        $this->assertEquals(2, $player->getMultiplier());

        $player = $playerService->upgradeMultiplier();

        $this->assertEquals(2, $player->getMultiplier());
    }
}
