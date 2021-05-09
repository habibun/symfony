<?php

namespace App\Controller;

use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Exception\CacheException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CacheController.
 *
 * @Route("/cache")
 */
class CacheController extends AbstractController
{
    /**
     * @Route("/file", name="cache.file")
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

    /**
     * @Route("/memcached", name="cache.memcached")
     *
     * @throws CacheException|InvalidArgumentException
     */
    public function memcachedAction(): Response
    {
        $client = MemcachedAdapter::createConnection('memcached://localhost');
        $cache = new MemcachedAdapter($client);
        $cacheKey = md5('123');
        $cachedItem = $cache->getItem($cacheKey);

        if (false === $cachedItem->isHit()) {
            $cachedItem->set($cacheKey, 'some value');
            $cache->save($cachedItem);
        }

        return $this->render('cache/memcached.html.twig', [
            'cache' => [
                'hit' => $cachedItem->isHit(),
            ],
        ]);
    }
}
