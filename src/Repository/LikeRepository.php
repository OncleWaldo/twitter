<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    // /**
    //  * @return Like[] Returns an array of Like objects
    //  */
    
    public function findOneOrCreate(array $criteria)
    {
        $like = $this->findOneBy(array(
            $user = $criteria["user"],
            $post = $criteria["post"]  
            
        )); 

        if ($like === NULL)
        {   
           $like->setPost($post);
           $like->setUser($user);
           $like = new $this->getClassName();
           $like->setTheDataSomehow($criteria); 
           $this->_em->persist($like);
           $this->_em->flush();
        }

        return $like;
    }

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
