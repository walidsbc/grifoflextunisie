<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                    'attr' => array(
                        'class' => 'md-input',
                        'data-parsley-title' => ''
                    )
                )
            )
            ->add('description', TextareaType::class, array(
                    'attr' => array(
                        'class' => 'md-input selecize_init',
                        'rows' => '8'
                    )
                )
            )
            ->add('mainPictureFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                    'required' => false
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => Slider::class
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_slider';
    }


}
