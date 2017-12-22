<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017. 12. 21.
 * Time: 14:14
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $em;
    private $router;

    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $session = new Session();
        $sessionCaptchaPhrase = $session->get('captchaPhrase');
        $inputCaptchaPhrase = $request->request->get('_captchaphrase');

        //if there was a captcha and it didn't match => logout
        if(isset($sessionCaptchaPhrase) && $sessionCaptchaPhrase != $inputCaptchaPhrase){
            return new RedirectResponse($this->router->generate('logout'));
        }

        $user = $token->getUser();
        $user->setLastLoggedInDate($user->getLoggedInDate());
        $user->setLoggedInDate(new \DateTime());

        //reset login attempts to 0
        $loginAttempt = $this->em->getRepository('AppBundle:LoginAttemp')->findOneBy(['ipAddress' => $request->getClientIp()]);
        $loginAttempt->setAttemptCount(0);

        $this->em->persist($loginAttempt);
        $this->em->persist($user);
        $this->em->flush();

        return new RedirectResponse($this->router->generate('homepage'));
    }

}