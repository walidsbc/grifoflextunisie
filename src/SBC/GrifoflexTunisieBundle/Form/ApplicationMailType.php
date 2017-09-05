<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\ApplicationMail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationMailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mailAddress',EmailType::class, array(
            'attr' => array(
                'class' => 'md-input',
                'data-parsley-mail' => ''
            )
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ApplicationMail::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_applicationmail';
    }


}
