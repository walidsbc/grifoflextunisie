<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\Quotation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName',null, array(
                'attr' => array(
                    'placeholder' => 'quotation.fullname'
                )
            ))
            ->add('email',null, array(
                'attr' => array(
                    'placeholder' => 'quotation.email'
                )
            ))
            ->add('phoneNumber',null, array(
                'attr' => array(
                    'placeholder' => 'quotation.phonenumber'
                )
            ))
            ->add('company',null, array(
                'attr' => array(
                    'placeholder' => 'quotation.company'
                )
            ))
            ->add('address',null, array(
                'attr' => array(
                    'placeholder' => 'quotation.address'
                )
            ))
            ->add('products', CollectionType::class, array(
                    'entry_type' => QuotationProductType::class,
                    'allow_add' => true,
                    'by_reference' => false,
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
            'data_class' => Quotation::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_quotation';
    }


}
