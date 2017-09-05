<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requestType', ChoiceType::class, array(
                    'choices' => array(
                        'Demande d\'emploi' => 'Demande d\'emploi',
                        'Demande de stage' => 'Demande de stage',
                    ),
                    'placeholder' => 'application.requestType',
                    'empty_data' => null,
                    'required' => false,
                    'attr' => array(
                        'required' => true,
                        'style' => 'width:100%; border: black solid 1px',

                    )
                )
            )
            ->add('applicationType', ChoiceType::class, array(
                    'choices' => array(
                        'Candidature spontanée' => 'Candidature spontanée',
                        'Suite à une offre publiée' => 'Suite à une offre publiée',
                    ),
                    'placeholder' => 'application.applicationType',
                    'empty_data' => null,
                    'required' => false,
                    'attr' => array(

                        'style' => 'width:100%; border: black solid 1px',
                        'onchange' => 'hideshowreference()',
                        'required' => true
                    )
                )
            )
            ->add('fullName', null, array(
                'attr' => array(
                    'placeholder' => 'application.fullname'
                )
            ))
            ->add('email', null, array(
                'attr' => array(
                    'placeholder' => 'application.email'
                )
            ))
            ->add('referenceOffre', null, array(
                'attr' => array(
                    'placeholder' => 'application.offre.reference'
                )
            ))
            ->add('note', null, array(
                'attr' => array(
                    'placeholder' => 'application.note',
                    'rows' => '7'
                )
            ))
            ->add('cvFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'required' => true,
                'attr' => array(
                    'class' => 'jfilestyle',
                    'data-input' => 'false'
                )
            ))
            ->add('motivationFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'required' => true,
                'attr' => array(
                    'class' => 'jfilestyle',
                    'data-input' => 'false'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Application::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_application';
    }


}
