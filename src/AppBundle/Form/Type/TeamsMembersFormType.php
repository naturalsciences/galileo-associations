<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamsMembersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'start_date',
            DateType::class,
            array(
                'choice_translation_domain' => 'messages',
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'placeholder' => 'app.form.teamsAndProjects.edit.date.placeholder',
                'format' => 'dd/MM/yyyy',
                'label' => '',
                'attr' => array(
                    'class' => 'js-datepicker form-control-date col-xs-4'
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
                    'placeholder' => 'app.form.teamsAndProjects.edit.date.placeholder',
                    'format' => 'dd/MM/yyyy',
                    'label' => '',
                    'attr' => array(
                        'class' => 'js-datepicker form-control-date col-xs-4'
                    ),
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['id'] .= '_'.$options['row_id'];
        $view->vars['name'] .= '_'.$options['row_id'];
        $view->vars['full_name'] .= '_'.$options['row_id'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\TeamsMembers',
                'row_id' => null
            )
        );
    }

}
