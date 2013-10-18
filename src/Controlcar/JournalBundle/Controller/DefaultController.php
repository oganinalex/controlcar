<?php

namespace Controlcar\JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ControlcarJournalBundle:Default:index.html.twig', array('name' => $name));
    }
}
