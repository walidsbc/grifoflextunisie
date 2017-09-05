<?php

namespace SBC\GrifoflexTunisieBundle\Form;

use SBC\GrifoflexTunisieBundle\Entity\Event;
use SBC\UtilsBundle\Utils\DateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\DateFormatter\DateFormat\TimezoneTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
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
                    'entry_type' => EventPictureType::class,
                    'allow_add' => true,
                    'by_reference' => false,
                )
            )
            ->add($builder
                ->create('eventDate', TextType::class, array('attr' => array(
                    'data-uk-datepicker' => '{format:\'DD/MM/YYYY\'}', 'class' => 'md-input')))
                ->addModelTransformer(new DateTransformer('d/m/Y')
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
                'data_class' => Event::class
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbc_grifoflextunisiebundle_event';
    }


}
