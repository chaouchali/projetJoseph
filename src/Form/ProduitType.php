<?php

namespace App\Form;

use App\Entity\Produit;
// use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, ['attr' => ['placeholder' => 'Enter le nom du produit  *']] , ['required'=>true])
            ->add('prix',NumberType::class, ['attr' => ['placeholder' => 'Enter le prix du produit *']] , ['required'=>true])
            ->add('stock',NumberType::class, ['attr' => ['placeholder' => 'Enter le quantite de stock du ce produit *']] , ['required'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
