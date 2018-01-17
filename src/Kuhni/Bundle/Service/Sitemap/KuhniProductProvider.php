<?php

namespace Kuhni\Bundle\Service\Sitemap;

use Skuola\SitemapBundle\Service\ParametersCollectionInterface;
use Doctrine\ORM\EntityManager;

class KuhniProductProvider implements ParametersCollectionInterface {

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getParametersCollection() {
        $collection = [];
        $kitchens = $this->entityManager->getRepository('KuhniBundle:Kuhni')
            ->createQueryBuilder('n')
            ->getQuery()
            ->getResult();
        foreach($kitchens as $kitchen) {
            $collection[] = [
                'slug' => 'kuhni-zov',
                'nameproduct' => $kitchen->getName()
            ];
        }
        return $collection;
    }
}