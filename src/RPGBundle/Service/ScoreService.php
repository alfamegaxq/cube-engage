<?php

namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Score;

class ScoreService
{
    /** @var PlayerService */
    private $playerService;
    /** @var EntityManager */
    private $em;

    public function __construct(
        PlayerService $playerService,
        EntityManager $em
    ) {
        $this->playerService = $playerService;
        $this->em = $em;
    }

    public function saveScore(): void
    {
        $player = $this->playerService->getActivePlayer();
        $score = new Score();
        $score->setName($player->getName())
            ->setScore($player->getScore() * $player->getMultiplier());

        $this->em->persist($score);
        $this->em->flush();
    }

    public function getTop(): array
    {
        $repository = $this->em->getRepository('RPGBundle:Score');
        return $repository->findBy([], ['score' => 'DESC'], Score::TOP_LIST_LENGTH);
    }
}
