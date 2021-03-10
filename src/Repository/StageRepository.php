<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    /**
        * @return Stage[] Returns an array of Stage objects
    */

    public function findStageByNomEntreprise($nom)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
            ->andWhere('e.nom = :val')
            ->setParameter('val', $nom)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findStageByNomFormation($nom)
    {   
        //recupération de l entitte
        $gestionnaireEntite=$this->getEntityManager();
        //creation de la requete
        $requete= $gestionnaireEntite->createQuery(
            'SELECT s 
            ROM App\Entity\Stage s
            ORDER BY s.id
            JOIN s.formation f
            WHERE f.intitule = :nom'
        );
        $requete->setParameter('nom',$nom);
        //execution et creation de la requete
        return $requete->execute();
    }

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
