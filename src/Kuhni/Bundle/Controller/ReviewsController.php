<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReviewsController extends Controller
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

    public function indexAction(){
        //Создаем построитель запросов Doctrine
        $result = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.id')
            ->getQuery()
            ->getResult();

        $image = array();
        if (!empty($result)){
            foreach ($result as $item) {
                $image[] = 'upload/catalog/' . $item->getImageName();
            }
        }

        $reviews = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Reviews')
            ->createQueryBuilder('n')
            ->where('n.approved = 1')
            ->orderBy('n.star', 'DESC')
            ->addOrderBy('n.created', 'DESC')
            ->getQuery()
            ->getResult();

        $completedProjects = $this->getCompletedProjects();
        $completedProjectsImage = array();
        foreach ($completedProjects as $item) {
            $completedProjectsImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];
        }

        $popular = $this->getPopular();
        $popularImage = array();
        foreach ($popular as $item) {
            $popularImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];
        }

        return $this->render('reviews/index.html.twig', array(
            'catalog' => $result,
            'imageCatalog' => $image,

            'reviews' => $reviews,

            'maps' => $this->getMapLocate(),

            'slug' => 'kuhni-zov',

            'kurs' => $this->getKurs(),
            'coef' => $this->getCoef(),
            'nds' => $this->getNDS(),
            
            'populars' => $popular,
            'popularImage' => $popularImage,
            'completedProjects' => $completedProjects,
            'completedProjectImage' => $completedProjectsImage,

            'formRequestCall' => $this->getRequestCallForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'formCostProject' => $this->getCostProject(),
            'formReview' => $this->getReviewForm()
        ));
    }

    private function getPopular(){
        $result = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.likes', 'DESC')
            ->getQuery()
            ->setMaxResults(12)
            ->getArrayResult();
        return $result;
    }

    private function getCompletedProjects(){
        $result = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.countProjects <> 0')
            ->orderBy('n.countProjects', 'DESC')
            ->getQuery()
            ->setMaxResults(12)
            ->getArrayResult();
        return $result;
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

    private function getKurs(){
        return $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Settings')
            ->findOneByName('kurs');
    }

    private function getNDS(){
        return $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Settings')
            ->findOneByName('nds');
    }

    private function getCoef(){
        return $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Settings')
            ->findOneByName('coef');
    }
}