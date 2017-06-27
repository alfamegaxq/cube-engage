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
    public function getPingAction(): JsonResponse
    {
        return new JsonResponse(['pong']);
    }

    /**
     * @Rest\Post("/player")
     */
    public function postPlayerAction(Request $request): Response
    {
        $name = $request->request->get('name');
        $type = $request->request->get('type');

        if ($this->isNameExisting($name)) {
            return new Response('', 409);
        }

        $player = new Player();
        $player->setType($type)
            ->setName($name)
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

    /**
     * @Rest\Post("/player/login")
     */
    public function postLoginAction(Request $request): Response
    {
        $player = $this->getDoctrine()->getRepository('RPGBundle:Player')->findOneBy(['name' => $request->request->get('name')]);
        $serializer = $this->get('serializer');

        $request->getSession()->set('apiToken', $player->getToken());

        return new Response($serializer->serialize($player, 'json'));
    }

    /**
     * @Rest\Post("/player/upgrade/attack")
     */
    public function postUpgradeAttack(): Response
    {
        $player = $this->get('player.service')->upgradeAttack();
        $serializer = $this->get('serializer');

        return new Response($serializer->serialize($player, 'json'));
    }

    /**
     * @Rest\Post("/player/upgrade/multiplier")
     */
    public function postUpgradeMultiplier(): Response
    {
        $player = $this->get('player.service')->upgradeMultiplier();
        $serializer = $this->get('serializer');

        return new Response($serializer->serialize($player, 'json'));
    }

    private function isNameExisting(string $name): bool
    {
        $em = $this->getDoctrine()->getManager();
        $existing = $em->getRepository('RPGBundle:Player')->findOneBy(['name' => $name]);

        return count($existing) != 0;
    }
}
