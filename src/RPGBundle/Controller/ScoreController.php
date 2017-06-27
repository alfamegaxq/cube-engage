<?php

namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ScoreController extends FOSRestController
{
    /**
     * @Rest\Post("/secure/score")
     */
    public function postScore(Request $request): Response
    {
        $playerService = $this->get('player.service');
        $player = $playerService->getActivePlayer();
        $scoreService = $this->get('score.service');

        if ($player->getHealth() <= 0) {
            $this->calculateAfterDeath($request);
        }

        $score = $scoreService->getTop();

        $serializer = $this->get('serializer');
        return new Response($serializer->serialize($score, 'json'));
    }

    private function calculateAfterDeath(Request $request): void
    {
        $this->get('score.service')->saveScore();
        $this->get('player.service')->deletePlayer();
        $request->getSession()->remove('map');
    }
}
