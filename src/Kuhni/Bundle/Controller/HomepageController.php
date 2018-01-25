<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    use TraitCallBackForm;
    use TraitCostProject;
    use TraitDesignerAtHome;
    use TraitFreeDesignShagForm;
    use TraitFreeProjectForm;
    use TraitReviewForm;
    use TraitRequestCallForm;
    use TraitZayavkaRazmer;

    private $colorStation;

    public function indexAction()
    {
        //Создаем построитель запросов Doctrine
        $result = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.id')
            ->getQuery()
            ->getResult();

        if (!empty($result)){
            $image = array();
            foreach ($result as $item) {
                $image[] = 'upload/catalog/' . $item->getImageName();
            }
        }else{
            $image[] = 'upload/catalog/no_image.jpg';
        }

        $sliders = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:HomeSliderImages')
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.output = 1')
            ->orderBy('n.priority', 'DESC')
            ->distinct()
            ->getQuery()
            ->getResult();

        return $this->render('homepage/index.html.twig', array(
            'catalog' => $result,
            'image' => $image,

            'sliders' => $sliders,

            'article' => $this->getArticle(),
            'titleMain' => $this->getTitleMain(),
            'maps' => $this->getMapLocate(),

            'formRequestCallModal' => $this->getRequestCallForm(),
            'formRequestCall' => $this->getRequestCallForm(),
            'formCostProject' => $this->getCostProject(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'form' => $this->getCallBackForm(),
            'reviews' => $this->getReviews(),
            'formReview' => $this->getReviewForm()
        ));
    }

    private function getArticle()
    {
        return $this->getDoctrine()->getManager()
            ->getRepository( 'KuhniBundle:Settings' )
            ->findOneBy(array('name' => 'article'))->getSetting();
    }

    private function getTitleMain()
    {
        return $this->getDoctrine()->getManager()
            ->getRepository( 'KuhniBundle:Settings' )
            ->findOneBy(array('name' => 'title-main'))->getSetting();
    }

    private function getReviews()
    {
        $reviews = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Reviews')
            ->createQueryBuilder('n')
            ->where('n.approved = 1')
            ->orderBy('n.star', 'DESC')
            ->addOrderBy('n.created', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        return $reviews;
    }

    private function getMapLocate()
    {
        $em = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Salon');
        $qb = $em->createQueryBuilder('u');
        $locate =
            $qb->where('u.vivodKarta = 1')->orderBy('u.id', 'ASC');
        return $locate->getQuery()->getResult();
    }
}