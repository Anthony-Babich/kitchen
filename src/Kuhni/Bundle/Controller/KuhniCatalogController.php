<?php

namespace Kuhni\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KuhniCatalogController extends Controller
{
    public function indexAction()
    {
        $resultStyle = $this->result('KuhniStyle');
        $imageStyle = $this->imagePath($resultStyle);

        $resultColor = $this->result('KuhniColor');
        $imageColor = $this->imagePath($resultColor);

        $resultConfig = $this->result('KuhniConfig');
        $imageConfig = $this->imagePath($resultConfig);

        $resultMaterial = $this->result('KuhniMaterial');
        $imageMaterial = $this->imagePath($resultMaterial);

        return $this->render('kuhni/index.html.twig', array(
            'style' => $resultStyle,
            'color' => $resultColor,
            'config' => $resultConfig,
            'material' => $resultMaterial,
            'imageStyle' => $imageStyle,
            'imageColor' => $imageColor,
            'imageConfig' => $imageConfig,
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
    private function imagePath($result){
        if (!empty($result)){
            foreach ($result as $item) {
                $image[] = 'upload/catalog/' . $item->getImageName();
            }
            return $image;
        }else{
            return 'Error! Bad source';
        }
    }
}
