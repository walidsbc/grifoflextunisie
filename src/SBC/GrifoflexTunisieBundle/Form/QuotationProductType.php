<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\QuotationProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', null, array(
                    'required' => false,
                    'attr' => array(
                        'data-name' => 'reference',
                        'placeholder' => 'product.reference',
                        'class' => 'form-control input-lg'
                    )
                )
            )
            ->add('title', null, array(
                    'required' => false,
                    'attr' => array(
                        'data-name' => 'title',
                        'placeholder' => 'product.title',
                        'class' => 'form-control input-lg'
                    )
                )
            )
            ->add('quantity', null, array(
                    'required' => false,
                    'attr' => array(
                        'data-name' => 'quantity',
                        'placeholder' => 'product.quantity',
                        'class' => 'form-control input-lg'
                    )
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => QuotationProduct::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_quotationproduct';
    }


}
