<?php

namespace App\Repository;

use App\Entity\Movie;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function saveOrUpdateMovie ($request, $movie) 
    {
        $data = json_decode($request->getContent());
        $movie->setName($data->name);
        $movie->setGender($data->gender);
        $movie->setWeek($data->week);
        $movie->setDescription($data->description);
        $movie->setCreatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));

        if(!$movie->getId() == null) {
            $movie->setUpdatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));
        }

        return $movie;
    
    }
}
