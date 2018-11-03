<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MysqlDemoController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/mysql/generateUuid", name="mysql.generateUuid")
     * @Method({"POST"})
     */
    public function generateUuidAction()
    {
        /* @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $statement = $entityManager->getConnection()->prepare('SELECT UUID() AS uuid');
        $statement->execute();
        $result = $statement->fetch();

        return new JsonResponse(['uuid' => $result['uuid']]);
    }

    /**
     * @return Response
     *
     * @Route("/mysql/listRandomEmployees", name="mysql.listRandomEmployees")
     * @Method({"GET"})
     */
    public function listRandomEmployeesAction()
    {
        /* @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $statement = $entityManager->getConnection()->prepare('SELECT * FROM employees ORDER BY RAND() LIMIT 5');
        $statement->execute();
        $result = $statement->fetchAll();

        return new JsonResponse(['list' => $result]);
    }

}
