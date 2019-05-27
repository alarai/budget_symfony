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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CurrentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Date de l\'opération',
            ])
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Nom de l\'opération'],
                'label' => 'Nom de l\'opération'
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie de l\'opération'
            ])
            ->add('moyen', EntityType::class, [
                'class' => Moyen::class,
                'choice_label' => 'nom',
                'label' => 'Moyen de paiement'
            ])
            ->add('valeur', TextType::class, [
                'attr' => ['placeholder' => '0.00']
            ])
            ->add('surcompte', ChoiceType::class, [
                'choices' => ['Oui' => true, 'Non' => false],
                'label' => 'Passer en compte ?'
            ])
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
