<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Sodium\add;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Super administrateur' => 'ROLE_SUPER_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('password')
        ->add(plainPaswword,RepeatedType::class,[
            'mapped' => false,
            'type'=> PasswordType::class,
            'invalid_message'=>'Thepassword fiels must match.',
            'options'=>['attr'=> ['class'=> 'password-field']],
            'required'=>true,
            'first_options'=>[
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min'=>6,
                        'minMessage'=>'Mot de passe trop court {{limit}} character',
                        'max'=> 4096,
                    ])
                ]
            ]


    ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
