<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

   

    /**
     * Trouver toutes les requetes et base pour Search 
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();

        // contrainte suivant la requete SEARCH
        if($search->getMaxPrice()){
            $query = $query
                ->andWhere('p.price < :maxprice' )
                ->setParameter( 'maxprice', $search->getMaxPrice())
                ;
        }

        if($search->getMinSurface()){
            $query = $query
                ->andWhere('p.surface >= :minsurface' )
                ->setParameter( 'minsurface', $search->getMinSurface())
                ;

        }

        if($search->getOptions()->count() > 0){
            //DQL action ds Doctrine , $k incremente pour get non attaquable
            $k=0;
            foreach($search->getOptions() as $option){
                $k++;
                $query = $query
                ->andWhere(":option$k MEMBER OF p.options" )
                ->setParameter( "option$k", $option );
                ;

            }
            

        }
        
        return $query->getQuery();
            // ->getResult() car paginator plugin
            
    }

    /**
     * Dernières Proprietés (reglé à  4)
     * @return Property[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;

    }

    /**
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder
    {
       return $this->createQueryBuilder('p')
           ->where('p.sold= false');
       
   }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */




     
}
