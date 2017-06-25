<?php

namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
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
    public function getPlayerAction(Request $req)
    {
        return new JsonResponse(['a']);
    }
    /**
     * @Rest\Post("/player")
     */
    public function postPlayerAction(Request $request)
    {
        $player = new Player();
        $player->setType($request->request->get('type'))
            ->setName($request->request->get('name'))
            ->setToken(md5(uniqid()));

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
