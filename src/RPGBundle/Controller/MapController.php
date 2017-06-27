<?php

namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class MapController extends FOSRestController
{
    /**
     * @Rest\Get("/secure/map")
     */
    public function getMapAction(Request $request)
    {
        $mapService = $this->get('map.service');

        if (!($map = $request->getSession()->get('map'))) {
            $map = $mapService->generateMap();
            $request->getSession()->set('map', $map);
        }

        return new JsonResponse($map);
    }

    /**
     * @Rest\Get("/secure/map/click/{row}/{column}", requirements={"row" = "\d+", "column" = "\d+"})
     */
    public function getMapClickAction(Request $request, int $row, int $column): JsonResponse
    {
        $map = $request->getSession()->get('map');
        $mapService = $this->get('map.service');
        $map = $mapService->hitTile($map, $row, $column);

        if (!$request->getSession()->has('map')) {
            return new JsonResponse([]);
        }

        $request->getSession()->set('map', $map);

        return new JsonResponse($map);
    }

    /**
     * @Rest\Post("/secure/map/delete")
     */
    public function deleteMap(Request $request): JsonResponse
    {
        $request->getSession()->remove('map');

        return new JsonResponse([]);
    }
}
