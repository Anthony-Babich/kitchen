<?php

namespace Kuhni\Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

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

            foreach ($result as $item) {
                $image[] = 'upload/kuhni/kitchens/' . $item['imageName'];
            }

            return $this->render('kuhni/kuhniParameters/more-product.html.twig', array(
                'kitchens' => $result,
                'image' => $image,
            ));
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

    private function getCatalogresult(){
        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n');
        $qb->select('n')->orderBy('n.id');
        return $qb->getQuery()->getResult();
    }
}
