<?php

namespace Kuhni\Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $fasades = $qb->getQuery()->getResult();

        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:KuhniMaterial')
            ->createQueryBuilder('n');
        $qb->select('n')
            ->where('n.id = :id')
            ->setParameter('id', $result->getIdKuhniMaterial());
        $material = $qb->getQuery()->getResult();

        $imageFasades = $this->imagePath($fasades, 'fasad');

        return $this->render('product/index.html.twig', array(
            'kitchen' => $result,
            'images' => $image,
            'slug' => $slug,
            'fasades' => $fasades,
            'imageFasades' => $imageFasades,
            'material' => $material,
            'catalog' => $resultCatalog,
            'imageCatalog' => $imageCatalog,
        ));
    }

    /**
     * @Route("/{slug}/", name="kuhni_parameters")
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function parametersAction($slug)
    {
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

        $image = $this->imagePath($result, 'kitchens');

        $countretult = ceil(count($result)/10);
        return $this->render('kuhni/kuhniParameters/index.html.twig', array(
            'kitchens' => $result,
            'countKitchens' => $countretult,
            'image' => $image,
            'slug' => $slug,
            'catalog' => $resultCatalog,
            'imageCatalog' => $imageCatalog,
        ));
    }

    private function searchParametr(string $slug){
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
                    ->findOneBy(array('slug' => $slug));
                if (empty($entity)){
                    $entity = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:KuhniColor')
                        ->findOneBy(array('slug' => $slug));
                    $id = $entity->getId();
                    $result = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:Kuhni')
                        ->findByIdKuhniColor($id);
                }else{
                    $id = $entity->getId();
                    $result = $this->getDoctrine()->getManager()
                        ->getRepository('KuhniBundle:Kuhni')
                        ->findByIdKuhniMaterial($id);
                }
            }else{
                $id = $entity->getId();
                $result = $this->getDoctrine()->getManager()
                    ->getRepository('KuhniBundle:Kuhni')
                    ->findByIdKuhniConfig($id);
            }
        }else{
            $id = $entity->getId();
            $result = $this->getDoctrine()->getManager()
                ->getRepository('KuhniBundle:Kuhni')
                ->findByIdKuhniStyle($id);
        }
        return $result;
    }

    private function getCatalogresult(){
        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n');
        $qb->select('n')->orderBy('n.id');
        return $qb->getQuery()->getResult();
    }
}
