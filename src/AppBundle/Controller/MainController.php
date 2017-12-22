<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/admin", name="adminIndex")
     */
    public function adminIndexAction()
    {
        return $this->render('main/admin.html.twig');
    }

    /**
     * @Route("/contentEditor", name="contentEditorIndex")
     */
    public function contentEditorAction()
    {
        return $this->render('main/contentEditor.html.twig');
    }

    /**
     * @Route("/plainUser", name="plainUserIndex")
     */
    public function plainUserAction()
    {
        return $this->render('main/plainUser.html.twig');
    }
}
