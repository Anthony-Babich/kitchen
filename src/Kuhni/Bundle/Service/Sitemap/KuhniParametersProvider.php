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
        $keys = $this->entityManager->getRepository( 'KuhniKeys' )
            ->createQueryBuilder('n')
            ->distinct('n.title')
            ->getQuery()
            ->getResult();
        foreach($keys as $key) {
            $collection[] = [
                'slug' => $key->getSlug(),
            ];
        }
        return $collection;
    }
}