<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CacheController.
 *
 * @Route("/cache", name="cache")
 */
class CacheController extends AbstractController
{
    /**
     * @Route("/file", name="cache")
     */
    public function fileAction(): Response
    {
        $cache = new FilesystemAdapter();
        $cachedData = $cache->getItem('random_number');

        if ($cachedData->isHit()) {
            return new JsonResponse([
                'data' => $cachedData->get(),
                'hit' => $cachedData->isHit(),
            ]);
        }

        $number = rand(1, 100);
        $cachedData->set($number);
        $cachedData->expiresAfter(10);
        $cache->save($cachedData);

        return new JsonResponse([
            'data' => $cachedData->get(),
            'hit' => $cachedData->isHit(),
        ]);
    }
}
