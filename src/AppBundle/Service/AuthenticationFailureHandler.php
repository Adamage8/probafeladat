<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017. 12. 21.
 * Time: 23:36
 */

namespace AppBundle\Service;


use AppBundle\Entity\LoginAttemp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{
    private $em;
    private $router;

    public function __construct(HttpKernelInterface $httpKernel, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->httpKernel = $httpKernel;
        $this->em = $em;
        $this->router = $router;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $clientIp = $request->getClientIp();
        $attempt = $this->em->getRepository('AppBundle:LoginAttemp')->findOneBy(['ipAddress' => $clientIp]);

        if(isset($attempt)){
            $attempt->incrementAttemptCount();
        }else{
            $attempt = new LoginAttemp($clientIp);
        }

        $this->em->persist($attempt);
        $this->em->flush();

        return new RedirectResponse($this->router->generate('login'));
    }
}