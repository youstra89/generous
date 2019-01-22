<?php

namespace App\Form;

use App\Entity\Puit;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class PuitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',         TextType::class,     ['label' => 'Nom de la mosquée', 'required' => true])
            ->add('localisation', TextType::class,     ['label' => 'Localisation', 'required' => true])
            ->add('cost',         TextType::class,     ['label' => 'Coût de la construction', 'required' => false])
            ->add('description',  TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('depth',        TextType::class,     ['label' => 'Profondeur', 'required' => false])
            ->add('date',         TextType::class,     ['label' => 'Date de construction', 'required' => false])
            ->add('recipient',    TextType::class, ['label' => 'Bénéficiaire', 'required' => true])
            ->add('user', EntityType::class, [
              'required' => false,
              'label' => 'Donnateur',
              'choice_label' => function ($user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
              },
              'class' => User::class,
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
            'data_class' => Puit::class,
        ]);
    }
}
