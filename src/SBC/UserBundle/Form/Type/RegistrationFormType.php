<?php

namespace SBC\UserBundle\Form\Type;


use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;


class RegistrationFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder
            ->add('roles', CollectionType::class, array(
                    'entry_type' => ChoiceType::class,
                    'label' => 'roles',
                    'entry_options' => array(
                        'choices' => array(
                            'Utilisateur' => 'ROLE_USER',
                            'Administrateur' => 'ROLE_SUPER_ADMIN',

                        ),
                        'placeholder' => 'Choisir le rôle de l\'utilisateur',
                        'empty_data' => null,
                        'expanded' => false,
                        'multiple' => false,
                    )
                )
            )
            ->add('save', SubmitType::class);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'user_registration';
    }

}
