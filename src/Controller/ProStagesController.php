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
use App\Form\EntrepriseType;
use App\Form\StageType;
use Doctrine\ORM\EntityManagerInterface;


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
     * * @Route("/ajouter/entreprise", name="prostages_ajouterEntreprise"))
     */

    public function ajouterEntreprise(Request $request, EntityManagerInterface $manager): Response
    {
        $entreprise = new Entreprise(); 

        // Creation du formulaire d'une entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        // Recuperation de la requete http
        $formulaireEntreprise->handleRequest($request);

        if ($formulaireEntreprise->isSubmitted()&& $formulaireEntreprise->isValid() )
        {
            // Enregistrer l'entreprise en bd
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('prostages_filtrer');

        }
        return $this->render('pro_stages/ajoutModifEntreprise.html.twig', [
            'vueFormulaire' => $formulaireEntreprise->createView(),
            'action' => "creer"
        ]);
    }   

      /**
     * @Route("/modifier/entreprise/{id}", name="prostages_modifierEntreprise")
     */

    public function modifierEntreprise(Request $request, Entreprise $entreprise, EntityManagerInterface $manager): Response
    {

        // Creation du formulaire d'une entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        // Recuperation de la requete http
        $formulaireEntreprise->handleRequest($request);
        if ($formulaireEntreprise->isSubmitted()&& $formulaireEntreprise->isValid() )
        {
            // Enregistrer l'entreprise en bd
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirectToRoute('prostages_filtrer');
        }
        return $this->render('pro_stages/ajoutModifEntreprise.html.twig', [
            'vueFormulaire' => $formulaireEntreprise->createView(),
            'action' => "modifier"
        ]);
    }

    /**
     * @Route("/filtrer", name="prostages_filtrer")
     */
    public function filtrer(EntrepriseRepository $entrepriseRepo, 
                            FormationRepository $formationRepo): Response
    {
        $entreprises = $entrepriseRepo->findAll();
        $formations = $formationRepo->findAll();

        return $this->render('pro_stages/filtrer.html.twig', [
            'entreprises' => $entreprises,
            'formations' => $formations 

        ]);    }

    /**
     * @Route("/ajouter/stage", name="prostages_ajouterStage")
     */

    public function ajouterStage(Request $request, EntityManagerInterface $manager): Response
    {
        $stage = new Stage(); 

        // Creation du formulaire d'un stage
        $formStage = $this->createForm(StageType::class, $stage);

        // Recuperation de la requete http
        $formStage->handleRequest($request);

        if ($formStage->isSubmitted() && $formStage->isValid()  )
        {
            // Enregistrer le stage en bd
            $manager->persist($stage);
            $manager->flush();
            return $this->redirectToRoute('prostages_accueil');
        }
        return $this->render('pro_stages/ajoutStage.html.twig', [
            'form' => $formStage->createView()
        ]);

    }

}
