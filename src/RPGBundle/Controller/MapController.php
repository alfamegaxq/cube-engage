<?php

namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class MapController extends FOSRestController
{
    /**
     * @Rest\Get("/secure/map/{level}", requirements={"level" = "\d+"})
     */
    public function getMapAction(Request $request, int $level)
    {
        $mapService = $this->get('map.service');
//        $request->getSession()->set('a', 'b');
        if (!($map = $request->getSession()->get('map'))) {
            $map = $mapService->generateMap(6);
            $request->getSession()->set('map', $map);
        }

        return new JsonResponse($map);
    }
}
