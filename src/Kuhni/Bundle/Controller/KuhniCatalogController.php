<?php

namespace Kuhni\Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/kuhni")
 */
class KuhniCatalogController extends Controller
{
    /**
     * @Route("/", name="kuhni_list")
     * @Method({"GET", "POST"})
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
     * @Route("/{slug}/", name="kuhni_style")
     * @Method({"GET", "POST"})
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showStyleAction($slug)
    {
        $entity = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:KuhniStyle')
            ->findOneBy(array('slug' => $slug));
        $id = $entity->getId();
        $result = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->findByIdKuhniStyle($id);

        $image = $this->imagePath($result, 'kitchens');

        return $this->render('kuhni/kuhniStyle/index.html.twig', array(
            'kitchens' => $result,
            'image' => $image,
            'slug' => $slug
        ));
    }

    /**
     * @Route("/{slugStyle}/{nameproduct}/", name="kuhni_product")
     * @Method({"GET", "POST"})
     * @param $slugStyle, $nameproduct
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productAction($slugStyle, $nameproduct)
    {
        $result = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Kuhni')
            ->findOneBy(array('slug' => $nameproduct));
        $id = $result->getId();

        $images = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:KuhniImages')
            ->findByKuhniId($id);

        $image = $this->imagePath($images, 'kitchens');

        $price = ($result->getPrice() * $result->getDiscount()) / 100 + $result->getPrice();

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

        $imageFasades = $this->imagePath($fasades, 'config');

        return $this->render('product/index.html.twig', array(
            'kitchen' => $result,
            'price' => $price,
            'images' => $image,
            'slugStyle' => $slugStyle,
            'fasades' => $fasades,
            'imageFasades' => $imageFasades,
            'material' => $material,
        ));
    }
}
