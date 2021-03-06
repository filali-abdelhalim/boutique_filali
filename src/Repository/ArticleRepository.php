<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

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
     * @return Query
     */
    
    public function findSearchArticles_pagination($name, $min, $max, $categories,$marques, $promo): Query
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.nomArt LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.prix_initial', 'ASC');

        if ($categories !== []) {
            $qb->andWhere('p.categorie IN (:categories)')
                ->setParameter('categories', $categories);
        }
        if ($marques !== []) {
            $qb->andWhere('p.marque IN (:marques)')
                ->setParameter('marques', $marques);
        }
        if ($min !== null) {
            $qb->andWhere('p.prix_final >= :min')
                ->setParameter('min', $min);
        }
        if ($max !== null) {
            $qb->andWhere('p.prix_final <= :max')
                ->setParameter('max', $max);
        }
        if ($promo === true) {
            $qb->andWhere('p.promo = :promo')
                ->setParameter('promo', $promo);
        }
       // $query = $qb->getQuery();


          return $qb->getQuery();
    }

   /**
     * @return Articles[]
     */
    public function findSearchArticles($name, $min, $max, $categories,$marques, $promo): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.nomArt LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.prix_initial', 'ASC');

        if ($categories !== []) {
            $qb->andWhere('p.categorie IN (:categories)')
                ->setParameter('categories', $categories);
        }
        if ($marques !== []) {
            $qb->andWhere('p.marque IN (:marques)')
                ->setParameter('marques', $marques);
        }
        if ($min !== null) {
            $qb->andWhere('p.prix_final >= :min')
                ->setParameter('min', $min);
        }
        if ($max !== null) {
            $qb->andWhere('p.prix_final <= :max')
                ->setParameter('max', $max);
        }
        if ($promo === true) {
            $qb->andWhere('p.promo = :promo')
                ->setParameter('promo', $promo);
        }
        $query = $qb->getQuery();


        return $query->execute();
    }

     /**
     * @return Articles[]
     */
    
    public function searchArticle($produit): array

    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.nomArt LIKE :name')
            ->setParameter('name', '%' . $produit . '%')
            ->orderBy('a.prix_initial', 'ASC');

        $query = $qb->getQuery();


        return $query->execute();

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
