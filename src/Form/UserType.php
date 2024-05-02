<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class, ['attr' => ['placeholder' => 'Enter l\'email d\'utilisateur  *']] , ['required'=>true])
            ->add('roles', ChoiceType::class, array(
                'attr'  =>  array('class' => 'form-control',
                'style' => 'margin:5px 0;'),
                'choices' => 
                array
                (
                    'ROLE_ADMIN' => array
                    (
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                    ),
                    'ROLE_USER' => array
                    (
                        'ROLE_USER' => 'ROLE_USER'
                    ),
                    
                ) 
                ,
                'multiple' => true,
                'required' => true,
                )
            )

            ->add('password',PasswordType::class, ['attr' => ['placeholder' => 'Enter le mot de passe d\'utilisateur *']] , ['required'=>true])
            ->add('nom',TextType::class, ['attr' => ['placeholder' => 'Enter le nom d\'utilisateur *']] , ['required'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
