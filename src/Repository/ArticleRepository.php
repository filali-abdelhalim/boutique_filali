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
     * @return Articles[]
     */
    public function findSearchArticles($name, $min, $max, $categories): array
    {
        dump($categories);
        $qb = $this->createQueryBuilder('p')
            ->where('p.nomArt LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.prix_initial', 'ASC');

        if ($categories !== []) {
            $qb->andWhere('p.categorie IN (:categories)')
                ->setParameter('categories', $categories);
        }
        if ($min !== null) {
            $qb->andWhere('p.prix_initial >= :min')
                ->setParameter('min', $min);
        }
        if ($max !== null) {
            $qb->andWhere('p.prix_initial <= :max')
                ->setParameter('max', $max);
        }
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
