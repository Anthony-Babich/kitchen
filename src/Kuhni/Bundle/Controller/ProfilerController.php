<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Kuhni\Bundle\Entity\FormCallBack;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class ProfilerController extends Controller
{
    use TraitFreeDesignShagForm;
    use TraitReviewForm;
    use TraitFreeProjectForm;
    use TraitZayavkaRazmer;
    use TraitCostProject;
    use TraitRequestCallForm;
    use TraitDesignerAtHome;
    use TraitCallBackForm;

    private $colorStation;
    private $slugs;

    public function indexAction(){
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

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Адреса салонов");

        return $this->render('profiler/index.html.twig', array(
            'salons' => $this->getAllSalon(),
            'catalog' => $result,
            'imageCatalog' => $image,

            'maps' => $this->getMapLocate(),

            'slug' => 'kuhni-zov',

            'kurs' => $this->getKurs(),
            'coef' => $this->getCoef(),
            'nds' => $this->getNDS(),

            'populars' => $popular,
            'popularImage' => $popularImage,
            'completedProjects' => $completedProjects,
            'completedProjectImage' => $completedProjectsImage,

            'form' => $this->getCallBackForm(),
            'formRequestCall' => $this->getRequestCallForm(),
            'formRequestCallModal' => $this->getRequestCallForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'formCostProject' => $this->getCostProject(),
            'formReview' => $this->getReviewForm()
        ));
    }

    public function searchAddressAction($slugAddress){
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

        $completedProjects = $this->getCompletedProjects();
        $completedProjectsImage = array();
        foreach ($completedProjects as $item) {
            $completedProjectsImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];
        }

        $salons = $this->getSalonByAddress($slugAddress);

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Адреса салонов", $this->get("router")->generate("salon-all"));
        $breadcrumbs->addItem("{$salons[0]->getGorod()}");

        $popular = $this->getPopular();
        $popularImage = array();
        foreach ($popular as $item) {
            $popularImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];
        }

        return $this->render('profiler/index.html.twig', array(
            'salons' => $salons,
            'catalog' => $result,
            'imageCatalog' => $image,

            'maps' => $this->getMapLocate(),

            'slug' => 'kuhni-zov',

            'kurs' => $this->getKurs(),
            'coef' => $this->getCoef(),
            'nds' => $this->getNDS(),

            'populars' => $popular,
            'popularImage' => $popularImage,
            'completedProjects' => $completedProjects,
            'completedProjectImage' => $completedProjectsImage,

            'form' => $this->getCallBackForm(),
            'formRequestCall' => $this->getRequestCallForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formRequestCallModal' => $this->getRequestCallForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'formCostProject' => $this->getCostProject(),
            'formReview' => $this->getReviewForm()
        ));
    }

    public function showAction($slugAddress, $slug){
        $salon = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Salon')
            ->findOneBy(array('slugAddress' => $slugAddress, 'slug' => $slug));

        if (is_object($salon) && !is_null($salon)){
            $headerImage = 'upload/salon/' . $salon->getImageName();
        } else{
            return $this->render('@Twig/Exception/error.html.twig', array('status_code' => 404, 'status_text' => 'No found salon!'));
        }

        $salonImages = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:SalonImages')->findBy(array('salonId' => $salon->getId()));
        $images = [];
        if (is_array($salonImages) && !is_null($salonImages)){
            foreach ($salonImages as $item)
               $images[] = 'upload/salon_all_images/' . $item->getImageName();
        } else $images[] = 'upload/catalog/no_image.jpg';
        if (null !== $this->getRequest()->get('offset')){
            $offset = $this->getRequest()->get('offset');
            $limit = $offset + 10;
        }else{
            $offset = 0;
            $limit = $offset + 10;
        }
        if (($offset <> 0)&&($limit <> 10)) {
            return $this->loadMore($salon->getId());
        }else{
            $projects = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Project')->findBy(array('idSalon' => $salon->getId()));
            $imageProject = [];
            if (is_array($projects) && !is_null($projects)){
                foreach ($projects as $item){
                    if (!empty($item->getImageName())){
                        $imageProject[] = 'upload/kuhni/kitchens/' . $item->getImageName();
                    } else{
                        $imageProject[] = 'upload/catalog/no_image.jpg';
                    }
                }
            } else $imageProject[] = 'upload/catalog/no_image.jpg';

            $breadcrumbs = $this->get('white_october_breadcrumbs');
            $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
            $breadcrumbs->addItem("Адреса салонов", $this->get("router")->generate("salon-all"));
            $breadcrumbs->addItem("{$salon->getGorod()}", $this->get("router")->generate("salon-address", ['slugAddress' => $slugAddress]));
            $breadcrumbs->addItem("{$salon->getTitle()}");

            $reviews = $this->getReviewsSalon($salon->getId());

            return $this->render('profiler/profileSalon.html.twig', array(
                'headerImage'   => $headerImage,
                'salon'         => $salon,
                'images'        => $images,

                'slugAddress' => $slugAddress,
                'slug' => $slug,

                'projects' => $projects,
                'imageProject' => $imageProject,
                'reviews' => $reviews,

                'kurs' => $this->getKurs(),
                'coef' => $this->getCoef(),
                'nds' => $this->getNDS(),

                'form' => $this->getCallBackFormWithSalon($slug),
                'formRequestCall' => $this->getRequestCallForm(),
                'formRequestCallModal' => $this->getRequestCallForm(),
                'formFreeProject' => $this->getFreeProjectForm(),
                'formZayavkaRazmer' => $this->getZayavkaRazmer(),
                'formFreeDesignShag' => $this->getFreeDesignShagForm(),
                'formDesignerAtHome' => $this->getDesignerAtHome(),
                'formCostProject' => $this->getCostProject(),
                'formReview' => $this->getReviewForm()
            ));
        }
    }

    public function loadMore(int $id)
    {
        if (null !== $this->getRequest()->get('offset')){
            $offset = $this->getRequest()->get('offset');
            $limit = $offset + 10;
        }else{
            $offset = 0;
            $limit = 10;
        }
        if (($offset <> 0)&&($limit <> 10)){

            $result = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Project')
                ->createQueryBuilder('n')
                ->select('n')
                ->where('n.idSalon = :id')
                ->setParameter('id', $id)
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

            if (!empty($result)){
                $image = array();
                foreach ($result as $item)
                    $image[] = 'upload/kuhni/kitchens/' . $item->getImageName();

                $kurs = $this->getKurs()->getSetting();
                $coef = $this->getCoef()->getSetting();
                $nds = $this->getNDS()->getSetting();

                $strResult = "<div class='container'><div class='row'><div class='col-xl-6 col-md-12 big-col'>";

                for ($i = 0; $i < count($result); $i++){
                    if ($i == 0){
                        $newPrice = round($result[$i]->getPrice() * $kurs * $nds * $coef);
                        $newNoDiscountPrice = number_format(round(($newPrice * $result[$i]->getDiscount())/100 + $newPrice), 0, '', ' ');
                        $newPrice = number_format($newPrice, 0, '', ' ');

                        $strResult .= "<a href='{$_SERVER['REQUEST_URI']}{$result[$i]->getSlug()}'>";
                        $strResult .= "<img class='slide-product-img big' src='/web/{$image[$i]}' alt={$result[$i]->getKeywords()} title={$result[$i]->getTitle()}>";
                        $strResult .= '<span class="pos-bot-l"';
                        if ($result[$i]->getDiscount() == 0){
                            $strResult .= 'style="width:100%;"';
                        }
                        $strResult .= "><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]->getTitle()}</b><br/>";
                        $strResult .= '</span></div></li>';

                        $strResult .= "<li class='right'><div class='text-right right'>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='text-right last-price'>старая цена <span class='through'> $newNoDiscountPrice <i class='fa fa-rub' aria-hidden='true'></i> </span><br/></span>";
                        }
                        $strResult .= "<span class='text-right now-price'>сейчас от $newPrice <i class='fa fa-rub' aria-hidden='true'></i></span>";
                        $strResult .= "</div></li></ul></span>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]->getDiscount()}%</b></span><br><span>скидка</span></span>";
                        }
                        $strResult .= "</a>";
                        $strResult .= "<button type='button' class='phone text-center' data-toggle='modal' data-target='#requestcall'><i class='fa fa-phone'></i></button>";
                        $strResult .= '<button type="button" id="like" data-id='.$result[$i]->getId().' style="margin-left: 10px;" class="like text-center"><i class="fa fa-heart"></i><span class="countLikes"> '.$result[$i]->getLikes().'</span></button>';
                    }
                }
                $strResult .= "</div>";

                $strResult .= "<div class='col-xs-12 col-sm-12 col-md-12 col-xl-6'><div class='row'><div class='col-xs-12 col-sm-12 col-md-6 small-col no-margin-left full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 2)&&($i > 0)){
                        $newPrice = round($result[$i]->getPrice() * $kurs * $nds * $coef);
                        $newNoDiscountPrice = number_format(round(($newPrice * $result[$i]->getDiscount())/100 + $newPrice), 0, '', ' ');
                        $newPrice = number_format($newPrice, 0, '', ' ');

                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]->getSlug()}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]->getKeywords()} title={$result[$i]->getTitle()}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'>";
                        $strResult .= "<li class='left'><div class='text-left'><span class='first-name'><b>{$result[$i]->getTitle()}</b><br/></span></div></li>";
                        $strResult .= "<li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от $newPrice <i class='fa fa-rub' aria-hidden='true'></i></span><br/>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='text-right last-price'>старая цена <span class='through'> $newNoDiscountPrice <i class='fa fa-rub' aria-hidden='true'></i></span></span>";
                        }
                        $strResult .= "</div></li></ul></span>";

                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]->getDiscount()}%</b></span><br><span>скидка</span></span>";
                        }
                        $strResult .= "</a>";
                        $strResult .= '<button type="button" class="phone text-center" data-toggle="modal" data-target="#requestcall"><i class="fa fa-phone"></i></button>';
                        $strResult .= '<button type="button" id="like" data-id='.$result[$i]->getId().' style="margin-left: 10px;" class="like text-center"><i class="fa fa-heart"></i><span class="countLikes"> '.$result[$i]->getLikes().'</span></button></div>';
                    }
                }
                $strResult .= "</div><div class='col-xs-12 col-sm-12 col-md-6 small-col full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 4)&&($i > 2)){
                        $newPrice = round($result[$i]->getPrice() * $kurs * $nds * $coef);
                        $newNoDiscountPrice = number_format(round(($newPrice * $result[$i]->getDiscount())/100 + $newPrice), 0, '', ' ');
                        $newPrice = number_format($newPrice, 0, '', ' ');

                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]->getSlug()}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]->getKeywords()} title={$result[$i]->getTitle()}>";
                        $strResult .= "<span class='pos-bot-l'><ul class='nav'>";
                        $strResult .= "<li class='left'><div class='text-left'><span class='first-name'><b>{$result[$i]->getTitle()}</b><br/></span></div></li>";
                        $strResult .= "<li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от $newPrice <i class='fa fa-rub' aria-hidden='true'></i></span><br/>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='text-right last-price'>старая цена <span class='through'> $newNoDiscountPrice <i class='fa fa-rub' aria-hidden='true'></i></span></span>";
                        }
                        $strResult .= "</div></li></ul></span>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]->getDiscount()}%</b></span><br><span>скидка</span></span>";
                        }
                        $strResult .= "</a>";
                        $strResult .= '<button type="button" class="phone text-center" data-toggle="modal" data-target="#requestcall"><i class="fa fa-phone"></i></button>';
                        $strResult .= '<button type="button" id="like" data-id='.$result[$i]->getId().' style="margin-left: 10px;" class="like text-center"><i class="fa fa-heart"></i><span class="countLikes"> '.$result[$i]->getLikes().'</span></button></div>';
                    }
                }
                $strResult .= "</div></div></div></div></div>";

                $strResult .= "<div class='container'><div class='row'><div class='col-md-12 col-xl-6'>";
                $strResult .= "<div class='row'><div class='col-sm-12 col-md-6 small-col first-small-col full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 6)&&($i > 4)){
                        $newPrice = round($result[$i]->getPrice() * $kurs * $nds * $coef);
                        $newNoDiscountPrice = number_format(round(($newPrice * $result[$i]->getDiscount())/100 + $newPrice), 0, '', ' ');
                        $newPrice = number_format($newPrice, 0, '', ' ');

                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]->getSlug()}'>";
                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]->getKeywords()} title={$result[$i]->getTitle()}>";
                        $strResult .= "<span class='pos-bot-l'><ul class='nav'>";
                        $strResult .= "<li class='left'><div class='text-left'><span class='first-name'><b>{$result[$i]->getTitle()}</b><br/></span></div></li>";
                        $strResult .= "<li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от $newPrice <i class='fa fa-rub' aria-hidden='true'></i></span><br/>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='text-right last-price'>старая цена <span class='through'> $newNoDiscountPrice <i class='fa fa-rub' aria-hidden='true'></i>  </span></span>";
                        }
                        $strResult .= "</div></li></ul></span>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]->getDiscount()}%</b></span><br><span>скидка</span></span>";
                        }
                        $strResult .= "</a>";
                        $strResult .= '<button type="button" class="phone text-center" data-toggle="modal" data-target="#requestcall"><i class="fa fa-phone"></i></button>';
                        $strResult .= '<button type="button" id="like" data-id='.$result[$i]->getId().' style="margin-left: 10px;" class="like text-center"><i class="fa fa-heart"></i><span class="countLikes"> '.$result[$i]->getLikes().'</span></button></div>';
                    }
                }
                $strResult .= "</div><div class='col-sm-12 col-md-6 small-col full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 8)&&($i > 6)){
                        $newPrice = round($result[$i]->getPrice() * $kurs * $nds * $coef);
                        $newNoDiscountPrice = number_format(round(($newPrice * $result[$i]->getDiscount())/100 + $newPrice), 0, '', ' ');
                        $newPrice = number_format($newPrice, 0, '', ' ');

                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]->getSlug()}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]->getKeywords()} title={$result[$i]->getTitle()}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class='first-name'><b>{$result[$i]->getTitle()}</b><br/></span></div></li>";
                        $strResult .= "<li class='right'><div class='text-right right'>";
                        $strResult .= "<span class='text-right now-price'>сейчас от $newPrice <i class='fa fa-rub' aria-hidden='true'></i></span><br/>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='text-right last-price'>старая цена <span class='through'> $newNoDiscountPrice <i class='fa fa-rub' aria-hidden='true'></i></span></span>";
                        }
                        $strResult .= "</div></li></ul></span>";

                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]->getDiscount()}%</b></span><br><span>скидка</span></span>";
                        }
                        $strResult .= "</a>";
                        $strResult .= '<button type="button" class="phone text-center" data-toggle="modal" data-target="#requestcall"><i class="fa fa-phone"></i></button>';
                        $strResult .= '<button type="button" id="like" data-id='.$result[$i]->getId().' style="margin-left: 10px;" class="like text-center"><i class="fa fa-heart"></i><span class="countLikes"> '.$result[$i]->getLikes().'</span></button></div>';
                    }
                }
                $strResult .= "</div></div></div><div class='col-xl-6 col-md-12 big-col'>";

                for ($i = 0; $i < count($result); $i++){
                    if ($i == 9){
                        $newPrice = round($result[$i]->getPrice() * $kurs * $nds * $coef);
                        $newNoDiscountPrice = number_format(round(($newPrice * $result[$i]->getDiscount())/100 + $newPrice), 0, '', ' ');
                        $newPrice = number_format($newPrice, 0, '', ' ');

                        $strResult .= "<a href='{$_SERVER['REQUEST_URI']}{$result[$i]->getSlug()}' class='big-a-10'>";
                        $strResult .= "<img class='slide-product-img big' src='/web/{$image[$i]}' alt={$result[$i]->getKeywords()} title={$result[$i]->getTitle()}>";

                        $strResult .= "<span class='pos-bot-l'";
                        if ($result[$i]->getDiscount() == 0){
                            $strResult .= 'style="width:100%;"';
                        }
                        $strResult .= "><ul class='nav'><li class='left'><div class='text-left'><span class='first-name'><b>{$result[$i]->getTitle()}</b><br/></span>";
                        $strResult .= "</div></li><li class='right'><div class='text-right right'>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='text-right last-price'>старая цена <span class='through'> $newNoDiscountPrice <i class='fa fa-rub' aria-hidden='true'></i></span><br/></span>";
                        }
                        $strResult .= "<span class='text-right now-price'>сейчас от $newPrice <i class='fa fa-rub' aria-hidden='true'></i></span>";
                        $strResult .= "</div></li></ul></span>";
                        if ($result[$i]->getDiscount() != 0){
                            $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]->getDiscount()}%</b></span><br><span>скидка</span></span>";
                        }
                        $strResult .= "</a>";
                        $strResult .= '<button type="button" class="phone big-a-10 text-center" data-toggle="modal" data-target="#requestcall"><i class="fa fa-phone"></i></button>';
                        $strResult .= '<button type="button" style="left: 20px;" id="like" data-id='.$result[$i]->getId().' class="like text-center"><i class="fa fa-heart"></i><span class="countLikes"> '.$result[$i]->getLikes().'</span></button>';
                    }
                }
                $strResult .= "</div></div></div>";

            }else{
                $strResult = "noMoreProduct";
            }

            return new Response($strResult);
        }
    }

    public function likeAction(){
        $session = $this->get('session');
        $em = $this->get('doctrine.orm.default_entity_manager');
        $project = $em->getRepository('KuhniBundle:Project')->findOneBy(array('id' => htmlspecialchars($_POST['id'])));
        if (!empty($project)){
            if (!empty($session->get($_POST['id'].'-project'))){
                if ($session->get($_POST['id'].'-project') == 0){
                    $session->set($_POST['id'].'-project', 1);
                    $project->setLikes($project->getLikes() + 1);
                }else{
                    $session->set($_POST['id'].'-project', 0);
                    if ($project->getLikes() == 0){
                        $project->setLikes($project->getLikes());
                    }else{
                        $project->setLikes($project->getLikes() - 1);
                    }
                }
            }else{
                $session->set($_POST['id'].'-project', 1);
                $project->setLikes($project->getLikes() + 1);
            }
            $em->persist($project);
            $em->flush();
            $response = json_encode(array('success' => 'success', 'count' => $project->getLikes()));
        }else{
            $response = json_encode(array('success' => 'noData'));
        }
        return new Response($response);
    }

    private function getReviewsSalon( $id ){
        return $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Reviews')
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.idSalon = :id')
            ->setParameter('id', $id)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    private function getAllSalon(){
        return $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Salon')
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.vivodSelect = 1')
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    private function getSalonByAddress($address){
        return $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Salon')
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.vivodSelect = 1')
            ->andWhere('n.slugAddress = :address')
            ->setParameter('address', $address)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
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

    private function getCallBackFormWithSalon($slug)
    {
        $callback = new FormCallBack();
        $this->slugs = $slug;

        $form = $this->createFormBuilder($callback)
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ваш EMAIL *',
                    'class' => 'form-control'
                ]
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('message', TextareaType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ваше Сообщение *',
                    'class' => 'form-control',
                    'maxlength' => '254'
                ]
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->andWhere('u.slug = :slug')->setParameter('slug', $this->slugs)->orderBy('u.id', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "«Белорусские кухни»  ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $form;
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
            ->findOneBy(array('name' => 'kurs'));
    }

    private function getNDS(){
        return $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Settings')
            ->findOneBy(array('name' => 'nds'));
    }

    private function getCoef(){
        return $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Settings')
            ->findOneBy(array('name' => 'coef'));
    }
}