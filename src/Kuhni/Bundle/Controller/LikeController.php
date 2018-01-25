<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function indexAction(){
        $session = $this->get('session');
        $em = $this->get('doctrine.orm.default_entity_manager');
        $kitchen = $em->getRepository('KuhniBundle:Kuhni')->findOneBy(array('id' => htmlspecialchars($_POST['id'])));
        if (!empty($kitchen)){
            if (!empty($session->get($_POST['id']))){
                if ($session->get($_POST['id']) == 0){
                    $session->set($_POST['id'], 1);
                    $kitchen->setLikes($kitchen->getLikes() + 1);
                }else{
                    $session->set($_POST['id'], 0);
                    if ($kitchen->getLikes() == 0){
                        $kitchen->setLikes($kitchen->getLikes());
                    }else{
                        $kitchen->setLikes($kitchen->getLikes() - 1);
                    }
                }
            }else{
                $session->set($_POST['id'], 1);
                $kitchen->setLikes($kitchen->getLikes() + 1);
            }
            $em->persist($kitchen);
            $em->flush();
            $response = json_encode(array('success' => 'success', 'count' => $kitchen->getLikes()));
        }else{
            $response = json_encode(array('success' => 'noData'));
        }
        return new Response($response);
    }
}