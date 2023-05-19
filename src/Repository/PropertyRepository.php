<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertyResearch;
use App\Form\PropertyResearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function save(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Property[] Returns an array of Property objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//




    /**
     * This method will be return an array of latest property class
     *
     * @return Property[]
     */
    public function findLatest(): array
    {
        return  $this->findVisibleQuery()
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }


    /**
     * This method will be return an array of all visible property class
     *
     * @param PropertyResearch $research
     * @return Query
     */
    public function  findAllVisibleQuery(PropertyResearch $research) : Query
    {

        $query = $this->findVisibleQuery();

        if ($research->getMaxPrice())
        {
            $query = $query
                ->andWhere('r.price < :maxPrice')
                ->setParameter('maxPrice', $research->getMaxPrice());
        }

        if ($research->getMinSurface())
        {
            $query = $query
                ->andWhere('r.surface > :minSurface')
                ->setParameter('minSurface', $research->getMinSurface());
        }

        return $query->getQuery();
    }


    private  function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('r')
            ->where('r.sold = false');
    }
}
