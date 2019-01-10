<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\PuitSearch;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PuitSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
              'required' => false,
              'label' => false,
              'attr' => [
                'placeholder' => 'Entrez un nom'
              ]
            ])
            ->add('localisation', TextType::class, [
              'required' => false,
              'label' => false,
              'attr' => [
                'placeholder' => 'Entrez une localisation'
              ]
            ])
            ->add('user', EntityType::class, [
              'required' => false,
              'label' => false,
              'placeholder' => 'Donnateur',
              'choice_label' => function ($user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
              },
              'class' => 'App\Entity\User',
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('u')
                  ->where('u.donnateur = TRUE');
              },
              'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PuitSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
      return '';
    }
}
