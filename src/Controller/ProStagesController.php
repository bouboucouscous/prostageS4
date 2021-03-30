<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages")
     */
    public function index(StageRepository $repositoryStage): Response
    {
        // Récupérer tous les stages enregistrés en BD
         $stages = $repositoryStage->findAllOptimise();

        // Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',
                              ['stages' => $stages]);
    }

    /**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function entreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
        // Récupérer toutes les entreprises enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();

        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/entreprises.html.twig',
                              ['entreprises' => $entreprises]);
    }

    /**
     * @Route("/formations", name="prostages_formations")
     */
    public function formations(FormationRepository $repositoryFormation): Response
    {
        // Récupérer toutes les formations enregistrées en BD
        $formations = $repositoryFormation->findAll();

        // Envoyer les formations récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/formations.html.twig',
                              ['formations' => $formations]);
    }

    /**
     * @Route("/stages/{id}", name="prostages_stages")
     */
    public function stages(Stage $stage): Response
    {
        // L'utilisation du mécanisme d'injection nous permet d'obtenir directement l'objet stage
        // La recherche par identifiant est effectuée automatiquement
        // Envoi du stage à la vue chargée de l'affichage
        return $this->render('pro_stages/stages.html.twig',
                              ['stage' => $stage]);
    }

    /**
     * @Route("/entreprise/{nom}", name="prostages_stagesParEntreprise")
     */

    public function stagesParEntreprise(StageRepository $stageRepo, $nom)
    {
        $stages = $stageRepo->findByEntreprise($nom);

            return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages,
            'filtrerPar' => $nom
        ]);
    }
     /**
     * @Route("/formation/{formation}", name="prostages_stagesParFormation")
     */

    public function stagesParFormation(StageRepository $stageRepo, $formation)
    {
        $stages = $stageRepo->findByFormation($formation);

            return $this->render('pro_stages/index.html.twig', [
            'stages' => $stages,
            'filtrerPar' => $formation
        ]);
    }

    /**
     * @Route("/ajouter/entreprise", name="prostages_ajout_entreprise")
     */

    public function ajoutEntreprise(): Response
    {
        $entreprise = new Entreprise(); 

        $formulaireEntreprise = $this->createFormBuilder($entreprise)
        ->add('nom')
        ->add('activite')
        ->add('adresse')
        ->getForm();


        return $this->render('pro_stages/ajoutEntreprise.html.twig', [
            'vueFormulaire' => $formulaireEntreprise->createView()
        ]);
    } 

    /**
     * * @Route("/ajouter/entreprise", name="prostages_ajouterEntreprise"))
     */

    public function ajoutEntreprise(): Response
    {
        $entreprise = new Entreprise(); 

        $formulaireEntreprise = $this->createFormBuilder($entreprise)
        ->add('nom')
        ->add('activite')
        ->add('adresse')
        ->getForm();


        return $this->render('pro_stages/ajoutEntreprise.html.twig', [
            'vueFormulaire' => $formulaireEntreprise->createView()
        ]);
    }   

}
