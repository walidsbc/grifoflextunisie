<?php

namespace SBC\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class ProfileFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Nouveau mot de passe', 'attr' => array('class' => 'md-input')),
                'second_options' => array('label' => 'Confirmer le mot de passe', 'attr' => array('class' => 'md-input')),
                'invalid_message' => 'Mots de passes non indentiques',
                'required' => false
            ))
            ->add('save', SubmitType::class);
    }

    public function getBlockPrefix()
    {
        return 'user_profile';
    }

}
