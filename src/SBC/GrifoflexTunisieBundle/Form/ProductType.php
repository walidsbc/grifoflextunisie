<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\Category;
use SBC\GrifoflexTunisieBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
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
            ->add('pictures', CollectionType::class, array(
                    'entry_type' => ProductPictureType::class,
                    'allow_add' => true,
                    'by_reference' => false,
                )
            )
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'placeholder' => '',
                'attr' => array(
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%'
                )
            ))
            ->add('mainPictureFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                    'required' => false
                )
            )
            ->add('technicalSheetFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                    'required' => false
                )
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => Product::class
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_product';
    }


}
