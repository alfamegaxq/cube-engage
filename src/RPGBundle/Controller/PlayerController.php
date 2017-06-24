<?php

namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use GuzzleHttp\Client;
use RPGBundle\Entity\Player;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class PlayerController extends FOSRestController
{

    /**
     * @Rest\Get("/player")
     */
    public function getPlayerAction()
    {
        return new JsonResponse(['a']);
    }
    /**
     * @Rest\Post("/player")
     */
    public function postPlayerAction(Request $request)
    {
        $data = $request->request->get('data');
        $player = new Player();
        $player->setType($data['type'])
            ->setName($data['name']);

        $this->savePlayer($player);
        $serializer = $this->get('serializer');

        return new Response($serializer->serialize($player, 'json'));
    }

    private function savePlayer($player): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
    }
}
