<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['required' => true, 'label' => 'Prénom'])
            ->add('lastname', TextType::class, ['required' => true, 'label' => 'Nom'])
            ->add('username', TextType::class, ['required' => true, 'label' => 'Nom \'utilisateur'])
            ->add('email', EmailType::class, ['required' => true, 'label' => 'Email'])
            ->add('origin', TextType::class, ['required' => true, 'label' => 'Pays d\'origine'])
            ->add('phone_number', TextType::class, ['required' => true, 'label' => 'Numéro de téléphone'])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false
        ]);
    }
}
