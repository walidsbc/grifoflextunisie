<?php

namespace SBC\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class ProfileEditFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('roles', CollectionType::class, array(
                    'entry_type' => ChoiceType::class,
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
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Nouveau mot de passe', 'attr' => array('class' => 'md-input')),
                'second_options' => array('label' => 'Confirmer le mot de passe', 'attr' => array('class' => 'md-input')),
                'invalid_message' => 'Mots de passes non indentiques',
                'required' => false
            ))
            ->add('save', SubmitType::class)
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();
                $role = array($data->getRoles()[0]);
                $form->get('roles')->setData($role);
            });;
    }

    public function getBlockPrefix()
    {
        return 'user_profile';
    }
}
