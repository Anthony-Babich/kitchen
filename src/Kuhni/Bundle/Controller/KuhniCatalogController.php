<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kuhni")
 */
class KuhniCatalogController extends Controller
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

    /**
     * @Route("/", name="kuhni_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $resultKeys = $this->result();
        $countKeys = count($resultKeys)-4;
        $imageKeys = $this->arrayImagePath($resultKeys, 'keys');

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Кухни");

        return $this->render('kuhni/index.html.twig', array(
            'keys' => $resultKeys,
            'countKey' => $countKeys,
            'imageKey' => $imageKeys,

            'maps' => $this->getMapLocate(),
            'titleKuhni' => $this->getTitleKuhni(),

            'formRequestCall' => $this->getRequestCallForm(),
            'formRequestCallModal' => $this->getRequestCallForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'formCostProject' => $this->getCostProject(),
            'form' => $this->getCallBackForm(),
        ));
    }

    /**
     * @Route("/{slug}/", name="kuhni_parameters")
     * @param string $slug
     * @return Response
     */
    public function parametersAction(string $slug)
    {
        if (null !== $this->getRequest()->get('offset')){
            $offset = $this->getRequest()->get('offset');
            $limit = $offset + 10;
        }else{
            $offset = 0;
            $limit = $offset + 10;
        }
        if (($offset <> 0)&&($limit <> 10)){

            $result = $this->searchParametr($slug, $offset, $limit);

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
        }else{
            //получение каталога товаров
            $resultCatalog = $this->getCatalogresult();
            $imageCatalog = $this->catalogImagePath($resultCatalog);

            $result = $this->searchParametr($slug);
            $image = array();
            foreach ($result as $item)
                $image[] = 'upload/kuhni/kitchens/' . $item->getImageName();

            $popular = $this->getPopular();
            $popularImage = array();
            foreach ($popular as $item)
                $popularImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];

            $completedProjects = $this->getCompletedProjects();
            $completedProjectsImage = array();
            foreach ($completedProjects as $item)
                $completedProjectsImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];

            //Хлебные крошки
            $breadcrumbs = $this->get('white_october_breadcrumbs');
            $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
            $breadcrumbs->addItem("Кухни", $this->get("router")->generate("kuhni_list"));
            $breadcrumbs->addItem("Все кухни", $this->get("router")->generate('kuhni_parameters', ['slug' => 'kuhni-zov']));
            if ($slug != 'kuhni-zov')
                $breadcrumbs->addItem("{$this->getNameBreadParam($slug)}");

            return $this->render('kuhni/kuhniParameters/index.html.twig', array(
                'kitchens' => $result,
                'image' => $image,
                'slug' => $slug,
                'catalog' => $resultCatalog,
                'imageCatalog' => $imageCatalog,

                'maps' => $this->getMapLocate(),
                'tags' => $this->getAllTags(),
                'article' => $this->getArticle($slug),

                'populars' => $popular,
                'popularImage' => $popularImage,
                'completedProjects' => $completedProjects,
                'completedProjectImage' => $completedProjectsImage,

                'kurs' => $this->getKurs(),
                'coef' => $this->getCoef(),
                'nds' => $this->getNDS(),

                'title' => $this->getTitleOnHead($slug),

                'formRequestCall' => $this->getRequestCallForm(),
                'formRequestCallModal' => $this->getRequestCallForm(),
                'formZayavkaRazmer' => $this->getZayavkaRazmer(),
                'formDesignerAtHome' => $this->getDesignerAtHome(),
                'formCostProject' => $this->getCostProject(),
                'formFreeProject' => $this->getFreeProjectForm(),
                'formFreeDesignShag' => $this->getFreeDesignShagForm(),
                'form' => $this->getCallBackForm(),
            ));
        }
    }

    /**
     * @Route("/{slug}/{nameproduct}/", name="kuhni_product")
     * @param $slug, $nameproduct
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productAction($slug, $nameproduct)
    {
        //получение каталога товаров
        $resultCatalog = $this->getCatalogresult();
        $imageCatalog = $this->catalogImagePath($resultCatalog);

        $result = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->findOneBy(array('slug' => $nameproduct));

        $id = $result->getId();
        $images = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:KuhniImages')
            ->findBy(array('kuhniId' => $id));
        $image = $this->arrayImagePath($images, 'kitchens');

        /*search all fasades
            SELECT * FROM `fasad_color`
            INNER JOIN fasadColor_kuhni ON fasadColor_kuhni.kuhni_id = id where id = 41;*/
        $fasadesColorKuhni = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Kuhni')
            ->createQueryBuilder('n')
            ->select('n, m')
            ->innerjoin('n.fasadColors', 'm')
            ->where('n.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        $imageFasadesColor = array();
        if (!empty($fasadesColorKuhni)){
            $fasadesColor = $fasadesColorKuhni[0]->getFasadColors();
            for ($i = 0; $i <= count($fasadesColor); $i++){
                if (!empty($fasadesColor[$i])){
                    $imageFasadesColor[] = $this->imagePath($fasadesColor[$i], 'fasad');
                }else{
                    $imageFasadesColor[] = $this->imagePath('', 'fasad');
                }
            }
        }else{
            $fasadesColor = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:FasadColor')->findOneById(1000);
            $imageFasadesColor[] = $this->imagePath('', 'fasad');
        }

        $fasadesTypeKuhni = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Kuhni')
            ->createQueryBuilder('n')
            ->select('n, m')
            ->innerjoin('n.fasadTypes', 'm')
            ->where('n.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        //обращение к фасадам
        //$fasadesType[0]->getFasadTypes()[$i]
        $imageFasadesType = array();
        if (!empty($fasadesTypeKuhni)){
            $fasadesType = $fasadesTypeKuhni[0]->getFasadTypes();
            for ($i = 0; $i <= count($fasadesType); $i++) {
                if (!empty($fasadesColor[$i])) {
                    $imageFasadesType[] = $this->imagePath($fasadesType[$i], 'fasad');
                } else {
                    $imageFasadesType[] = $this->imagePath('', 'fasad');
                }
            }
        } else {
            $fasadesType = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:FasadType')->findOneById(1000);
            $imageFasadesType[] = $this->imagePath('', 'fasad');
        }

        //Хлебные крошки
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Кухни", $this->get("router")->generate("kuhni_list"));
        if ($slug != 'kuhni-zov'){
            $breadcrumbs->addItem("{$this->getNameBreadParam($slug)}", $this->get("router")->generate('kuhni_parameters', ['slug' => $slug]));
        }
        $breadcrumbs->addItem("{$result->getTitle()}");

        $popular = $this->getPopular();
        $popularImage = array();
        foreach ($popular as $item)
            $popularImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];

        $completedProjects = $this->getCompletedProjects();
        $completedProjectsImage = array();
        foreach ($completedProjects as $item)
            $completedProjectsImage[] = 'upload/kuhni/kitchens/' . $item['imageName'];

        return $this->render('product/index.html.twig', [
            'maps' => $this->getMapLocate(),

            'kitchen' => $result,
            'images' => $image,
            'slug' => $slug,

            'catalog' => $resultCatalog,
            'imageCatalog' => $imageCatalog,

            'populars' => $popular,
            'popularImage' => $popularImage,
            'completedProjects' => $completedProjects,
            'completedProjectImage' => $completedProjectsImage,

            'kurs' => $this->getKurs(),
            'coef' => $this->getCoef(),
            'nds' => $this->getNDS(),

            'title' => $result->getTitle(),
            //FORMS
            'formRequestCall' => $this->getRequestCallForm(),
            'formRequestCallModal' => $this->getRequestCallForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'formCostProject' => $this->getCostProject(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'form' => $this->getCallBackForm(),

            'fasadesColor' => $fasadesColor,
            'imageFasadesColor' => $imageFasadesColor,
            'fasadesType' => $fasadesType,
            'imageFasadesType' => $imageFasadesType,
        ]);
    }

    private function getPopular(){
        return $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.likes', 'DESC')
            ->getQuery()
            ->setMaxResults(12)
            ->getArrayResult();
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

    /**
     * @param string $db
     * @return mixed
     */
    private function result(){
        $result = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:KuhniKeys')
            ->createQueryBuilder('n')
            ->select('n')
            ->distinct('n.title')
            ->orderBy('n.updated', 'DESC')
            ->getQuery()
            ->getResult();
        return $result;
    }

    private function searchParametr(string $slug, $offset = 0, $limit = 10){
        if ($slug == 'kuhni-zov'){
            $result = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Kuhni')
                ->createQueryBuilder('n')
                ->select('n')
                ->orderBy('n.likes', 'DESC')
                ->getQuery()
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getResult();
        }else{
            $key = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:KuhniKeys')->findOneBy(array('slug' => $slug));
            $result = $this->getDoctrine()->getManager()
                ->getRepository('KuhniBundle:Kuhni')
                ->createQueryBuilder('n')
                ->select('n, m')
                ->innerJoin('n.kuhniKeys', 'm')
                ->where('m.id = :id')
                ->setParameter('id', $key->getId())
                ->orderBy('n.likes', 'DESC')
                ->getQuery()
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getResult();
        }
        return $result;
    }

    private function getArticle(string $slug)
    {
        return $this->getDoctrine()->getManager()
            ->getRepository( 'KuhniBundle:KuhniKeys')
            ->findOneBy(array('slug' => $slug))->getArticle();
    }

    private function getCatalogResult(){
        return $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.id')
            ->getQuery()
            ->getResult();
    }

    private function getAllTags(){
        return $this->getDoctrine()->getManager()->getRepository('KuhniBundle:KuhniKeys')->findAll();
    }

    private function getNameBreadParam(string $slug){
        return $this->getDoctrine()->getManager()
            ->getRepository( 'KuhniBundle:KuhniKeys' )
            ->findOneBy(array('slug' => $slug))->getTitle();
    }

    /**
     * @param $result
     * @return array
     */
    private function catalogImagePath(array $result){
        $imageCatalog = array();
        if (!empty($result)){
            foreach ($result as $item) {
                $imageCatalog[] = 'upload/catalog/' . $item->getImageName();
            }
        }else{
            $imageCatalog[] = 'bundles/kuhni/img/no_image.jpg';
        }
        return $imageCatalog;
    }

    /**
     * @param $result
     * @param string $path
     * @return array|string
     */
    private function imagePath($result, string $path){
        if (!empty($result)){
            return 'upload/kuhni/' . $path . '/' . $result->getImageName();
        }else{
            return 'bundles/kuhni/img/no_image.jpg';
        }
    }

    /**
     * @param $result
     * @return array|string
     */
    private function arrayImagePath(array $result, $path){
        if (!empty($result)){
            $image = array();
            foreach ($result as $item) {
                $image[] = 'upload/kuhni/' . $path . '/' . $item->getImageName();
            }
            return $image;
        }else{
            return 'bundles/kuhni/img/no_image.jpg';
        }
    }

    private function getTitleOnHead(string $slug){
        return $this->getDoctrine()->getManager()
            ->getRepository( 'KuhniBundle:KuhniKeys' )
            ->findOneBy(array('slug' => $slug))->getCaption();
    }

    private function getTitleKuhni()
    {
        return $this->getDoctrine()->getManager()
            ->getRepository( 'KuhniBundle:Settings' )
            ->findOneBy(array('name' => 'title-kuhni'))->getSetting();
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