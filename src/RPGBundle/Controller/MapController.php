<?php

namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;

class MapController extends FOSRestController
{

    /**
     * @Rest\Get("/map/{level}", requirements={"level" = "\d+"})
     */
    public function getMapAction(int $level)
    {
        $mapService = $this->get('map.service');
        return new JsonResponse($mapService->generateMap($level));
    }
}
