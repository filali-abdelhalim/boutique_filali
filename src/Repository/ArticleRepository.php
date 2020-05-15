<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

   /**
    * @return Article[] Returns an array of Article objects
    */
   
    public function findSearch(SearchData $search):array
    {
        
        $query = $this
                ->createQueryBuilder('a')
                ->select('c', 'a')
                ->join('a.categories', 'c');

    if (!empty($search->q)) {
        $query = $query
            ->andWhere('a.nomArt LIKE :q')
            ->setParameter('q', "%{$search->q}%");

    }
    if (!empty($search->min)) {
        $query = $query
            ->andWhere('a.prix >= :min')
            ->setParameter('min', $search->min);
    }

    if (!empty($search->max)) {
        $query = $query
            ->andWhere('a.prix <= :max')
            ->setParameter('max', $search->max);
    }

    if (!empty($search->promo)) {
        $query = $query
            ->andWhere('a.promo = 1');
    }

    if (!empty($search->categorie)) {
        $query = $query
            ->andWhere('c.id IN (:categorie)')
            ->setParameter('categorie', $search->categorie);
    }

        return $query->getQuery()->getResult();

    }
    

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
