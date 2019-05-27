<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Moyen;
use App\Entity\OpRecur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecuringType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie d\'opération',
            ])
            ->add('moyen', EntityType::class, [
                'class' => Moyen::class,
                'choice_label' => 'nom',
                'label' => 'Moyen de paiement'
            ])
            ->add('valeur', TextType::class, [
                'attr' => ['placeholder' => '0.00']
            ])
            ->add('Enregistrer', SubmitType::class, ['attr' => ['class' => 'btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OpRecur::class,
        ]);
    }
}
