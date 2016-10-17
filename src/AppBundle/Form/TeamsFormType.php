<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'international_name_language',
            ChoiceType::class,
            array(
                'choices' => array(
                    'en' => 'en',
                    'fr' => 'fr',
                    'nl' => 'nl',
                ),
                'choice_translation_domain' => 'content-db'
            )
        )
            ->add(
                'international_name'
            )
            ->add('international_description')
            ->add(
                'international_cascade',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'None of the translated versions' => 0,
                        'The corresponding language translated version' => 1,
                        'The translated versions' => 2,
                    )
                )
            )
            ->add('name_en')
            ->add('description_en')
            ->add('name_fr')
            ->add('description_fr')
            ->add('name_nl')
            ->add('description_nl')
            ->add(
                'start_date',
                DateType::class,
                array(
                    'choice_translation_domain' => 'messages',
                    'required' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                    'placeholder' => 'app.form.teams.startDate.placeholder',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'class' => 'js-datepicker'
                    ),
                )
            )
            ->add(
                'end_date',
                DateType::class,
                array(
                    'choice_translation_domain' => 'messages',
                    'required' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                    'placeholder' => 'app.form.teams.startDate.placeholder',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'class' => 'js-datepicker'
                    ),
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'AppBundle\Entity\Teams')
        );
    }

}
