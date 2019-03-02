<?php

namespace AppBundle\Controller;

use Identicon\Identicon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DashboardDemoController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/mysql", name="mysql")
     *
     * @return Response
     */
    public function mysqlAction(): Response
    {
        return $this->renderDashboard('mysql');
    }

    /**
     * @Route("/redis", name="redis")
     *
     * @return Response
     */
    public function redisAction(): Response
    {
        return $this->renderDashboard('redis');
    }

    /**
     * @Route("/mail", name="mail")
     *
     * @return Response
     */
    public function mailAction(): Response
    {
        return $this->renderDashboard('mail');
    }

    /**
     * @Route("/elasticsearch", name="elasticsearch")
     *
     * @return Response
     */
    public function elasticsearchAction(): Response
    {
        return $this->renderDashboard('elasticsearch');
    }

    /**
     * @param string $section
     *
     * @return Response
     */
    protected function renderDashboard(string $section): Response
    {
        $hash = getenv('FEATER__INSTANCE_HASH');

        return $this->render(
            sprintf('AppBundle:dashboard:%s.html.twig', $section),
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'identiconImageData' => $hash
                    ? base64_encode((new Identicon())->getImageData($hash, 120))
                    : null,
            ]
        );
    }
}
