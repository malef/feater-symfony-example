<?php

namespace AppBundle\Controller;

use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Mailer;
use Swift_Message;
use Swift_SwiftException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailcatcherDemoController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/mailcatcher/sendEmail", name="mailcatcher.sendEmail")
     * @Method({"POST"})
     */
    public function sendEmailAction(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        $faker = Factory::create();

        /* @var Swift_Mailer $mailer */
        $mailer = $this->get('mailer');

        try {
            $mailer->send(
                (new Swift_Message(
                    $faker->sentence(4),
                    implode(' ', $faker->sentences(3)),
                    'text/plain'
                ))
                    ->setTo($requestData['emailAddress'])
                    ->setFrom('noreply@php-app.docker-template')
            );
        } catch (Swift_SwiftException $e) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        return new Response('', Response::HTTP_OK);
    }
}
