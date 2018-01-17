<?php

namespace Kuhni\Bundle\Service\Sitemap;

use Skuola\SitemapBundle\Service\ParametersCollectionInterface;
use Doctrine\ORM\EntityManager;

class KuhniParametersProvider implements ParametersCollectionInterface {

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getParametersCollection() {
        $collection = [];
        $styles = $this->entityManager->getRepository('KuhniBundle:KuhniStyle')
            ->createQueryBuilder('n')
            ->distinct('n.title')
            ->getQuery()
            ->getResult();
        foreach($styles as $style) {
            $collection[] = [
                'slug' => $style->getSlug(),
            ];
        }
        $materials = $this->entityManager->getRepository('KuhniBundle:KuhniMaterial')
            ->createQueryBuilder('n')
            ->distinct('n.title')
            ->getQuery()
            ->getResult();
        foreach($materials as $material) {
            $collection[] = [
                'slug' => $material->getSlug(),
            ];
        }
        $colors = $this->entityManager->getRepository('KuhniBundle:KuhniColor')
            ->createQueryBuilder('n')
            ->distinct('n.title')
            ->getQuery()
            ->getResult();
        foreach($colors as $color) {
            $collection[] = [
                'slug' => $color->getSlug(),
            ];
        }
        $configs = $this->entityManager->getRepository('KuhniBundle:KuhniConfig')
            ->createQueryBuilder('n')
            ->distinct('n.title')
            ->getQuery()
            ->getResult();
        foreach($configs as $config) {
            $collection[] = [
                'slug' => $config->getSlug(),
            ];
        }
        return $collection;
    }
}