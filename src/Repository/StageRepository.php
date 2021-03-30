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

    public function findStageByNomEntreprise($nom): ?Stage
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
    public function findStageByNomFormation($nom): ?Stage
    {   
        //recupération de l entitte
        $gestionnaireEntite=this.getEntityManager();
        //creation de la requete
        $requete= $gestionnaireEntite->createQuery(
            'SELECT s, f, e
            FROM Stage s
            JOIN s.formations f
            JOIN s.entreprise e
            WHERE f.intitule = :nom'
        );
        $requete->setParameter('nom',$nom);
        //execution et creation de la requete
        return $requete->execute();
    }

    /**
    * @return Stage[] Returns an array of Stage objects
    */

    public function findByEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->addSelect('f')
            ->join('s.entreprise','e')
            ->join('s.formations','f')
            ->andWhere('e.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nomEntreprise)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
    * @return Stage[] Returns an array of Stage objects
    */

    public function findByFormation($nomFormation)
    {
        // Recuperer le gestionnaire d'entité

        $entityManager = $this->getEntityManager();

        // Construction de la requete
        $requete = $entityManager->createQuery(
            'SELECT s
            FROM Stage s
            JOIN s.formations f
            WHERE f.Formation = :nomFormation');

        // Definition de la valeur du parametre
        $requete->setParameter('nomFormation', $nomFormation);

        // Retourner les resultats

        return $requete->execute();
    }

    public function findAllOptimise()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->addSelect('f')
            ->join('s.entreprise','e')
            ->join('s.formations','f')
            ->getQuery()
            ->getResult()
        ;
    }
}
