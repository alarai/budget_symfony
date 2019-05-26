<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Moyen;
use App\Entity\Courant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CurrentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('nom', TextType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'nom'
            ])
            ->add('moyen', EntityType::class, [
                'class' => Moyen::class,
                'choice_label' => 'nom'
            ])
            ->add('valeur', TextType::class)
            ->add('surcompte', TextType::class)
            ->add('Enregistrer', SubmitType::class, ['attr' => ['class' => 'btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Courant::class,
            'editId' => -1
        ]);
    }
}
