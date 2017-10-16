<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Method({"GET", "POST"})
 * @Route("/kuhni")
 */
class KuhniCatalogController extends Controller
{
    /**
     * @Route("/", name="kuhni_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $resultMaterial = $this->result('KuhniMaterial');
        $countMaterial = count($resultMaterial)-4;
        $imageMaterial = $this->imagePath($resultMaterial, 'material');

        $resultColor = $this->result('KuhniColor');

        $resultStyle = $this->result('KuhniStyle');
        $countStyle = count($resultStyle)-4;
        $imageStyle = $this->imagePath($resultStyle, 'style');

        $resultConfig = $this->result('KuhniConfig');
        $countConfig = count($resultConfig)-4;
        $imageConfig = $this->imagePath($resultConfig, 'config');

        //Хлебные крошки
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        // Simple example
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Кухни");

        return $this->render('kuhni/index.html.twig', array(
            'style' => $resultStyle,
            'countStyle' => $countStyle,
            'imageStyle' => $imageStyle,

            'color' => $resultColor,

            'config' => $resultConfig,
            'countConfig' => $countConfig,
            'imageConfig' => $imageConfig,

            'material' => $resultMaterial,
            'countMaterial' => $countMaterial,
            'imageMaterial' => $imageMaterial,
        ));
    }

    /**
     * @param string $db
     * @return mixed
     */
    private function result(string $db){
        $db = 'KuhniBundle:'.$db;
        $qb = $this->getDoctrine()->getManager()->getRepository($db)
            ->createQueryBuilder('n');
        $qb->select('DISTINCT n.title');
        $titles = $qb->getQuery()->getResult();

        foreach ($titles as $title) {
            $result[] = $this->getDoctrine()->getManager()
                ->getRepository($db)
                ->findOneBy(array('title' => $title['title']));
        }
        if (!empty($result)){
            return $result;
        }
    }

    /**
     * @param $result
     * @return array|string
     */
    private function imagePath($result, $path){
        if (!empty($result)){
            if (is_array($result)){
                foreach ($result as $item) {
                    $image[] = 'upload/kuhni/' . $path . '/' . $item->getImageName();
                }
            }else{
                $image = 'upload/kuhni/' . $path . '/' . $result->getImageName();
            }
            return $image;
        }else{
            return 'Error! Bad source';
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
        if (!empty($resultCatalog)){
            foreach ($resultCatalog as $item) {
                $imageCatalog[] = 'upload/catalog/' . $item->getImageName();
            }
        }else{
            $imageCatalog[] = 'none';
        }

        $result = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->findOneBy(array('slug' => $nameproduct));
        $id = $result->getId();
        $images = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:KuhniImages')
            ->findByKuhniId($id);
        $image = $this->imagePath($images, 'kitchens');

        //search all fasades
        //SELECT * FROM `fasad_color` where fasad_color.id_kuhni_material = 3;
        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:FasadColor')
            ->createQueryBuilder('n');
        $qb->select('n')
            ->where('n.idKuhniMaterial = :id')
            ->setParameter('id', $result->getIdKuhniMaterial());
        $fasadesColor = $qb->getQuery()->getResult();
        $imageFasadesColor = $this->imagePath($fasadesColor, 'fasad');

        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:FasadType')
            ->createQueryBuilder('n');
        $qb->select('n')
            ->where('n.idKuhniMaterial = :id')
            ->setParameter('id', $result->getIdKuhniMaterial());
        $fasadesType = $qb->getQuery()->getResult();
        $imageFasadesType = $this->imagePath($fasadesType, 'fasad');

        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:KuhniMaterial')
            ->createQueryBuilder('n');
        $qb->select('n')
            ->where('n.id = :id')
            ->setParameter('id', $result->getIdKuhniMaterial());
        $material = $qb->getQuery()->getResult();

        //Хлебные крошки
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        // Simple example
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Кухни", $this->get("router")->generate("kuhni_list"));
        $breadcrumbs->addItem("{$this->getNameBreadParam($slug)}", $this->get("router")->generate('kuhni_parameters', ['slug' => $slug]));
        $breadcrumbs->addItem("{$result->getTitle()}");

        return $this->render('product/index.html.twig', array(
            'kitchen' => $result,
            'images' => $image,
            'slug' => $slug,
            'fasadesColor' => $fasadesColor,
            'imageFasadesColor' => $imageFasadesColor,
            'fasadesType' => $fasadesType,
            'imageFasadesType' => $imageFasadesType,
            'material' => $material,
            'catalog' => $resultCatalog,
            'imageCatalog' => $imageCatalog,
        ));
    }

    /**
     * @Route("/{slug}/", name="kuhni_parameters")
     * @param string $slug
     * @return Response
     */
    public function parametersAction(string $slug)
    {
        if (!is_null($this->getRequest()->get('offset'))){
            $offset = $this->getRequest()->get('offset');
            $limit = $offset + 10;
        }else{
            $offset = 0;
            $limit = $offset + 10;
        }
        if (($offset <> 0)&&($limit <> 10)){

            $result = $this->searchParametr($slug, $limit, $offset);

            if (!empty($result)){

                foreach ($result as $item) {
                    $image[] = 'upload/kuhni/kitchens/' . $item['imageName'];
                }

                $strResult = "<div class='container'><div class='row'><div class='col-xl-6 col-md-12 big-col'>";

                for ($i = 0; $i < count($result); $i++){
                    if ($i == 0){
                        $strResult .= "<a href='{$_SERVER['REQUEST_URI']}{$result[$i]['slug']}'>";

                        $strResult .= "<img class='slide-product-img big' src='/web/{$image[$i]}' alt={$result[$i]['keywords']} title={$result[$i]['title']}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]['title']}</b><br/></span>";
                        $strResult .= "<span class='first-desc'>";
                        if ($result[$i]['fixedPrice']){
                            $strResult .= "*Цена указана за 1 метр погонный кухни";
                        }else{
                            $strResult .= "*Цену и наличие уточняйте";
                        }
                        $strResult .= "</span></div></li><li class='right'><div class='text-right right'><span class='text-right last-price'>старая цена";
                        $strResult .= "<span class='through'>{$result[$i]['noDiscountPrice']}</span><br/></span><span class='text-right now-price'>сейчас от {$result[$i]['price']}</span>";
                        $strResult .= "</div></li></ul></span>";
                        $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]['discount']}%</b></span><br><span>скидка</span></span>";
                        $strResult .= "<span class='phone text-center'><i class='fa fa-phone'></i></span>";
                        $strResult .= "<span class='like'><i class='fa fa-heart'></i> {$result[$i]['likes']}</span>";
                        $strResult .= "</a>";
                    }
                }
                $strResult .= "</div>";

                $strResult .= "<div class='col-xs-12 col-sm-12 col-md-12 col-xl-6'><div class='row'><div class='col-xs-12 col-sm-12 col-md-6 small-col no-margin-left full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 2)&&($i > 0)){
                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]['slug']}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]['keywords']} title={$result[$i]['title']}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]['title']}</b><br/></span>";
                        $strResult .= "</div></li><li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от {$result[$i]['price']}</span><br/>";
                        $strResult .= "<span class='text-right last-price'>старая цена<span class='through'>{$result[$i]['noDiscountPrice']}</span></span>";
                        $strResult .= "</div></li></ul></span>";

                        $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]['discount']}%</b></span><br><span>скидка</span></span>";
                        $strResult .= "<span class='phone text-center'><i class='fa fa-phone'></i></span>";
                        $strResult .= "<span class='like'><i class='fa fa-heart'></i> {$result[$i]['likes']}</span>";
                        $strResult .= "</a></div>";
                    }
                }
                $strResult .= "</div><div class='col-xs-12 col-sm-12 col-md-6 small-col full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 4)&&($i > 2)){
                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]['slug']}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]['keywords']} title={$result[$i]['title']}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]['title']}</b><br/></span>";
                        $strResult .= "</div></li><li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от {$result[$i]['price']}</span><br/>";
                        $strResult .= "<span class='text-right last-price'>старая цена<span class='through'>{$result[$i]['noDiscountPrice']}</span></span>";
                        $strResult .= "</div></li></ul></span>";

                        $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]['discount']}%</b></span><br><span>скидка</span></span>";
                        $strResult .= "<span class='phone text-center'><i class='fa fa-phone'></i></span>";
                        $strResult .= "<span class='like'><i class='fa fa-heart'></i> {$result[$i]['likes']}</span>";
                        $strResult .= "</a></div>";
                    }
                }
                $strResult .= "</div></div></div></div></div>";

                $strResult .= "<div class='container'><div class='row'><div class='col-md-12 col-xl-6'>";
                $strResult .= "<div class='row'><div class='col-sm-12 col-md-6 small-col first-small-col full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 6)&&($i > 4)){
                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]['slug']}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]['keywords']} title={$result[$i]['title']}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]['title']}</b><br/></span>";
                        $strResult .= "</div></li><li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от {$result[$i]['price']}</span><br/>";
                        $strResult .= "<span class='text-right last-price'>старая цена<span class='through'>{$result[$i]['noDiscountPrice']}</span></span>";
                        $strResult .= "</div></li></ul></span>";

                        $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]['discount']}%</b></span><br><span>скидка</span></span>";
                        $strResult .= "<span class='phone text-center'><i class='fa fa-phone'></i></span>";
                        $strResult .= "<span class='like'><i class='fa fa-heart'></i> {$result[$i]['likes']}</span>";
                        $strResult .= "</a></div>";
                    }
                }
                $strResult .= "</div><div class='col-sm-12 col-md-6 small-col full-screen'>";

                for ($i = 0; $i < count($result); $i++){
                    if (($i <= 8)&&($i > 6)){
                        $strResult .= "<div class='col-12 big-col'><a href='{$_SERVER['REQUEST_URI']}{$result[$i]['slug']}'>";

                        $strResult .= "<img class='slide-product-img' src='/web/{$image[$i]}' alt={$result[$i]['keywords']} title={$result[$i]['title']}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]['title']}</b><br/></span>";
                        $strResult .= "</div></li><li class='right'><div class='text-right right'><span class='text-right now-price'>сейчас от {$result[$i]['price']}</span><br/>";
                        $strResult .= "<span class='text-right last-price'>старая цена<span class='through'>{$result[$i]['noDiscountPrice']}</span></span>";
                        $strResult .= "</div></li></ul></span>";

                        $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]['discount']}%</b></span><br><span>скидка</span></span>";
                        $strResult .= "<span class='phone text-center'><i class='fa fa-phone'></i></span>";
                        $strResult .= "<span class='like'><i class='fa fa-heart'></i> {$result[$i]['likes']}</span>";
                        $strResult .= "</a></div>";
                    }
                }
                $strResult .= "</div></div></div>";

                $strResult .= "<div class='col-xl-6 col-md-12 big-col'>";

                for ($i = 0; $i < count($result); $i++){
                    if ($i == 9){
                        $strResult .= "<a href='{$_SERVER['REQUEST_URI']}{$result[$i]['slug']}' class='big-a-10'>";

                        $strResult .= "<img class='slide-product-img big' src='/web/{$image[$i]}' alt={$result[$i]['keywords']} title={$result[$i]['title']}>";

                        $strResult .= "<span class='pos-bot-l'><ul class='nav'><li class='left'><div class='text-left'><span class=first-name><b>{$result[$i]['title']}</b><br/></span>";
                        $strResult .= "<span class='first-desc'>";
                        if ($result[$i]['fixedPrice']){
                            $strResult .= "*Цена указана за 1 метр погонный кухни";
                        }else{
                            $strResult .= "*Цену и наличие уточняйте";
                        }
                        $strResult .= "</span></div></li><li class='right'><div class='text-right right'><span class='text-right last-price'>старая цена";
                        $strResult .= "<span class='through'>{$result[$i]['noDiscountPrice']}</span><br/></span><span class='text-right now-price'>сейчас от {$result[$i]['price']}</span>";
                        $strResult .= "</div></li></ul></span>";
                        $strResult .= "<span class='pos-bot-r desc text-center'><span class='title'><b>{$result[$i]['discount']}%</b></span><br><span>скидка</span></span>";
                        $strResult .= "<span class='phone text-center'><i class='fa fa-phone'></i></span>";
                        $strResult .= "<span class='like'><i class='fa fa-heart'></i> {$result[$i]['likes']}</span>";
                        $strResult .= "</a>";
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

            if (!empty($resultCatalog)){
                foreach ($resultCatalog as $item) {
                    $imageCatalog[] = 'upload/catalog/' . $item->getImageName();
                }
            }else{
                $imageCatalog = 'none';
            }

            $result = $this->searchParametr($slug);

            foreach ($result as $item) {
                $image[] = 'upload/kuhni/kitchens/' . $item['imageName'];
            }

            //Хлебные крошки
            $breadcrumbs = $this->get('white_october_breadcrumbs');
            $breadcrumbs->addItem("Главная", $this->get("router")->generate("homepage"));
            $breadcrumbs->addItem("Кухни", $this->get("router")->generate("kuhni_list"));
            $breadcrumbs->addItem("{$this->getNameBreadParam($slug)}");

            return $this->render('kuhni/kuhniParameters/index.html.twig', array(
                'kitchens' => $result,
                'image' => $image,
                'slug' => $slug,
                'catalog' => $resultCatalog,
                'imageCatalog' => $imageCatalog,
            ));
        }
    }

    private function searchParametr(string $slug, $offset = 0, $limit = 10){
        $entity = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:KuhniStyle')
            ->findOneBy(array('slug' => $slug));
        if (empty($entity)){
            $entity = $this->getDoctrine()->getManager()
                ->getRepository('KuhniBundle:KuhniConfig')
                ->findOneBy(array('slug' => $slug));
            if (empty($entity)){
                $entity = $this->getDoctrine()->getManager()
                    ->getRepository('KuhniBundle:KuhniMaterial')
                    ->findBy(array('slug' => $slug));
                if (empty($entity)){
                    $entity = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:KuhniColor')
                        ->findOneBy(array('slug' => $slug));
                    $id = $entity->getId();
                    $result = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:Kuhni')
                        ->createQueryBuilder('n')
                        ->select('n')
                        ->where('n.idKuhniColor = :id')
                        ->orderBy('n.id', 'ASC')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->setFirstResult($offset)
                        ->setMaxResults($limit)
                        ->getArrayResult();
                }else{
                    if (is_array($entity)){
                        foreach ($entity as $item){
                            $id[] = $item->getId();
                        }
                    }else{
                        $id[] = $entity->getId();
                    }
                    $result = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:Kuhni')
                        ->createQueryBuilder('n')
                        ->select('n')
                        ->where('n.idKuhniMaterial IN (:id)')
                        ->orderBy('n.id', 'ASC')
                        ->setParameters(array('id' => $id))
                        ->getQuery()
                        ->setFirstResult($offset)
                        ->setMaxResults($limit)
                        ->getArrayResult();
                }
            }else{
                $id = $entity->getId();
                $result = $this->getDoctrine()->getManager()
                    ->getRepository('KuhniBundle:Kuhni')
                    ->createQueryBuilder('n')
                    ->select('n')
                    ->where('n.idKuhniConfig = :id')
                    ->orderBy('n.id', 'ASC')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getArrayResult();
            }
        }else{
            $id = $entity->getId();
            $result = $this->getDoctrine()->getManager()
                ->getRepository('KuhniBundle:Kuhni')
                ->createQueryBuilder('n')
                ->select('n')
                ->where('n.idKuhniStyle = :id')
                ->orderBy('n.id', 'ASC')
                ->setParameter('id', $id)
                ->getQuery()
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getArrayResult();
        }
        return $result;
    }

    private function getCatalogResult(){
        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n');
        $qb->select('n')->orderBy('n.id');
        return $qb->getQuery()->getResult();
    }

    private function getNameBreadParam(string $slug){
        $entity = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:KuhniStyle')
            ->findOneBy(array('slug' => $slug));
        if (empty($entity)) {
            $entity = $this->getDoctrine()->getManager()
                ->getRepository('KuhniBundle:KuhniConfig')
                ->findOneBy(array('slug' => $slug));
            if (empty($entity)) {
                $entity = $this->getDoctrine()->getManager()
                    ->getRepository('KuhniBundle:KuhniMaterial')
                    ->findBy(array('slug' => $slug));
                if (empty($entity)) {
                    $entity = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:KuhniColor')
                        ->findOneBy(array('slug' => $slug));
                }
            }
        }
        return $entity->getTitle();
    }
}
