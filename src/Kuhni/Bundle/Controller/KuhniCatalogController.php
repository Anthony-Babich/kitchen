<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KuhniCatalogController extends Controller
{
    public function indexAction()
    {
        $resultStyle = $this->result('KuhniStyle');
        $countStyle = count($resultStyle)-4;
        $imageStyle = $this->imagePath($resultStyle, 'style');

        $resultColor = $this->result('KuhniColor');

        $resultConfig = $this->result('KuhniConfig');
        $countConfig = count($resultConfig)-4;
        $imageConfig = $this->imagePath($resultConfig, 'config');

        $resultMaterial = $this->result('KuhniMaterial');
        $countMaterial = count($resultMaterial)-4;
        $imageMaterial = $this->imagePath($resultMaterial, 'material');

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

    private function result(string $db){
        $db = 'KuhniBundle:'.$db;
        $qb = $this->getDoctrine()->getManager()->getRepository($db)
            ->createQueryBuilder('n');
        $qb->select('n')->orderBy('n.id');
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $result
     * @return array|string
     */
    private function imagePath($result, $path){
        if (!empty($result)){
            foreach ($result as $item) {
                $image[] = 'upload/kuhni/' . $path . '/' . $item->getImageName();
            }
            return $image;
        }else{
            return 'Error! Bad source';
        }
    }
}
