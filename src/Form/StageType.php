<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('description')
            ->add('competenceRequise')
            ->add('dateDebut')
            ->add('duree')
            ->add('emailEntreprise')
            ->add('formations',EntityType::class, array(
            'class'=>Formation::class,
            'choice_label'=>'intitule',
            'multiple'=>true,
            'expanded'=>true))
            ->add('entreprise', EntityType::class, array(
            'class'=>Entreprise::class,
            'choice_label'=>'nom',
            'multiple'=>false,
            'expanded'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
