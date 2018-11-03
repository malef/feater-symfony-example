<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class XDomainController extends Controller
{
    /**
     * @param Request $req
     * @return string
     * @throws AccessDeniedHttpException
     */
    public function slaveAction(Request $req)
    {
        $allowedOrigins = $this->getParameter('allowed_origins');
        $origin = $this->refererToOrigin($req->headers->get('Referer'));

        foreach ($allowedOrigins as $pattern) {
            if (preg_match($pattern, $origin)) {
                return $this->get('templating')->renderResponse('::proxy.html.twig', ['origin' => $origin]);
            }
        };

        throw new AccessDeniedHttpException('Referer does not match any of allowed origins.');
    }

    /**
     * @param string $referer
     * @return string
     * @throws AccessDeniedHttpException
     */
    protected function refererToOrigin($referer)
    {
        if (!$referer) {
            throw new AccessDeniedHttpException('Referer header not found');
        }

        $components = parse_url($referer);
        $origin = sprintf('%s://%s', $components['scheme'], $components['host']);

        if (array_key_exists('port', $components)) {
            $origin = sprintf('%s:%s', $origin, $components['port']);
        }

        return $origin;
    }
}
