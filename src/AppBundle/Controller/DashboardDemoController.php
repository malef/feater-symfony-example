<?php

namespace AppBundle\Controller;

use Identicon\Identicon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardDemoController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $identicon = new Identicon();
        $featerInstanceHash = getenv('FEATER__INSTANCE_HASH');

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'identiconImageData' => $featerInstanceHash
                ? base64_encode($identicon->getImageData($featerInstanceHash, 120))
                : null,
        ]);
    }
}
