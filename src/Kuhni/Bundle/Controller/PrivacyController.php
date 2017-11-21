<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PrivacyController extends Controller
{
    public function indexAction(){
        return $this->render('privacy/index.html.twig', array(
        ));
    }
}