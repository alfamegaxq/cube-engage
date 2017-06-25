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
     * @Rest\Get("/ping")
     */
    public function getPingAction(Request $req): JsonResponse
    {
        return new JsonResponse(['pong']);
    }

    /**
     * @Rest\Post("/player")
     */
    public function postPlayerAction(Request $request): Response
    {
        $player = new Player();
        $player->setType($request->request->get('type'))
            ->setName($request->request->get('name'))
            ->setToken(md5(uniqid()));

        $this->savePlayer($player);
        $request->getSession()->set('apiToken', $player->getToken());

        $serializer = $this->get('serializer');

        return new Response($serializer->serialize($player, 'json'));
    }

    private function savePlayer(Player $player): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
    }

    /**
     * @Rest\Get("/player/{token}")
     */
    public function getPlayer(string $token): Response
    {
        $player = $this->getDoctrine()->getRepository('RPGBundle:Player')->findOneBy(['token' => $token]);
        $serializer = $this->get('serializer');

        return new Response($serializer->serialize($player, 'json'));
    }
}
