<?php

namespace App\Form;

use App\Domain\Users\DTO\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add(
                'password',
                PasswordType::class,
            )   
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Utilisateur' => "USER",
                        'Admin' => "ADMIN",
                    ],
                ]
            )
            ->add(
                'Ajouter',
                SubmitType::class
            );

        $builder
            ->get('roles')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($arrayRoles) {
                        if ($arrayRoles && in_array('ADMIN', $arrayRoles)) {
                            return "ADMIN";
                        }
                        return "USER";
                    },
                    function ($stringRoles) {
                        if ($stringRoles === "ADMIN") {
                            return ['ADMIN', 'USER'];
                        }
                        return ['USER'];
                    }    
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
               'data_class' => User::class,
            ]
        );
    }
}
