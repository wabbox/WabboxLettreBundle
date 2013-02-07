<?php

namespace Wabbox\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WabboxCvBundle:Default:index.html.twig');
    }
    public function presentationAction()
    {
        return $this->render('WabboxCvBundle:Default:presentation.html.twig');
    } 
    public function competenceAction()
    {
        return $this->render('WabboxCvBundle:Default:competence.html.twig');
    }
}
