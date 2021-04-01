<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Stage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('niveau')
            ->add('ville')
            ->add('stages')
            ->add('stages',EntityType::class, array(
                'class'=>Stage::class,
                'choice_label'=>'intitule',
                'multiple'=>true,
                'expanded'=>true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
