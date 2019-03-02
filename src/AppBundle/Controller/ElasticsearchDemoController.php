<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Elastica\Index;
use Elastica\Query\FunctionScore;
use Elastica\Query\MatchAll;
use Elastica\Result;
use FOS\ElasticaBundle\Finder\FinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ElasticsearchDemoController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/elasticsearch/listRandomAccounts", name="elasticsearch.listRandomAccounts")
     * @Method({"GET"})
     */
    public function listRandomAccountsAction()
    {
        /** @var Index $index */
        $index = $this->container->get('fos_elastica.index.sample');
        $resultSet = $index->search(
            (new FunctionScore())->addRandomScoreFunction(bin2hex(random_bytes(32)))
        );

        $responseContent = [
            'total_hits' => $resultSet->getTotalHits(),
            'hits' => array_map(
                function (Result $result) {
                    return $result->getHit();
                },
                $resultSet->getResults()
            ),
        ];

        return new JsonResponse(['list' => $responseContent]);
    }

}
