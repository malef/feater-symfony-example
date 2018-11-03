<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedisDemoController extends Controller
{
    const REDIS_KEY_DOTS_COUNT = 'dotsCount';

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/redis/addDot", name="redis.addDot")
     * @Method({"POST"})
     */
    public function addDotAction(Request $request)
    {
        $redisClient = $this->get('snc_redis.default');
        $redisClient->incr(self::REDIS_KEY_DOTS_COUNT);
        $dotsCount = $redisClient->get(self::REDIS_KEY_DOTS_COUNT);

        return new JsonResponse(['dotsCount' => (int) $dotsCount]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/redis/removeDot", name="redis.removeDot")
     * @Method({"POST"})
     */
    public function removeDotAction(Request $request)
    {
        $redisClient = $this->get('snc_redis.default');
        $redisClient->decr(self::REDIS_KEY_DOTS_COUNT);
        $dotsCount = $redisClient->get(self::REDIS_KEY_DOTS_COUNT);

        if ($dotsCount < 0) {
            $redisClient->set(self::REDIS_KEY_DOTS_COUNT, 0);

            return new JsonResponse(['dotsCount' => 0]);
        }

        return new JsonResponse(['dotsCount' => (int) $dotsCount]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/redis/getDotCount", name="redis.getDotCount")
     * @Method({"GET"})
     */
    public function getDotCountAction(Request $request)
    {
        $dotsCount = $this->get('snc_redis.default')->get(self::REDIS_KEY_DOTS_COUNT);

        return new JsonResponse(['dotsCount' => (int) $dotsCount]);
    }
}
