<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class HomepageController extends Controller
{
    private $session;
    public function __construct()
    {
        $this->session = new Session();
        $this->session->set('likeKuhniProduct', 0);
    }

    public function indexAction()
    {
        //Создаем построитель запросов Doctrine
        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n');
        //Добавляем к запросу left join c сущностью "Категория"
        //при выводе в списке названия категории нового запроса не будет
        $qb->select('n')->orderBy('n.id');
        $result = $qb->getQuery()->getResult();

        if (!empty($result)){
            foreach ($result as $item) {
                $image[] = 'upload/catalog/' . $item->getImageName();
            }
        }

        if (!empty($image)){
            return $this->render('homepage/index.html.twig', array(
                'catalog' => $result,
                'image' => $image,
            ));
        }
    }
}
