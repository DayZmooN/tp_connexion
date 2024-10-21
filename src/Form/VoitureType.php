<?php

namespace App\Form;

use App\Entity\Composant;
use App\Entity\Marque;
use App\Entity\Voiture;
use App\Repository\MarqueRepository;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Doctrine\ORM\EntityRepository;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', TextType::class, [
                'label' => 'model',
            ])
            ->add('price', TextType::class, [
                'label' => 'prix',
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => function (Marque $marque): string {
                    return $marque->getLabel();
                },
                'query_builder' => function (MarqueRepository $repo) {
                    return $repo->createQueryBuilder('m')
                        ->where('m.archive = true');
                },
            ])
            ->add('composant', EntityType::class, [
                'class' => Composant::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
            ])
            ->add('archive', ChoiceType::class, [
                'choices' => [
                    'masquer' => false,
                    'afficher' => true,
                ],
                'expanded' => true,
                'label' => 'archive',
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
