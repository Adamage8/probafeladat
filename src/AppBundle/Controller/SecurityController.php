<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Form\UserLoginForm;
use Gregwar\Captcha\CaptchaBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    private $MAX_ATTEMPTS = 3;
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $em = $this->getDoctrine()->getManager();
        $loginAttempt = $em->getRepository('AppBundle:LoginAttemp')->findOneBy(['ipAddress' => $request->getClientIp()]);

        $captchaSrc = null;
        $captchaPhrase = null;
        $session = new Session();
        if(isset($loginAttempt)){
            if($loginAttempt->getAttemptCount() > $this->MAX_ATTEMPTS){
                //create captcha and save its phrase to session
                $builder = new CaptchaBuilder();
                $builder->build();
                $captchaPhrase = $builder->getPhrase();

                $captchaSrc = $builder->inline();
            }
        }
        $session->set('captchaPhrase', $captchaPhrase);


        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'captchaSrc' => $captchaSrc
        ));
    }
}
