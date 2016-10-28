<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsFormType extends AbstractType
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
                    'choice_translation_domain' => 'content-db',
                    'label' => 'app.form.teamsAndProjects.edit.internationalNameLanguage',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control col-xs-6 col-sm-5 required rbins-language-source',
                        'data-cascade-field-class' => '.rbins-name-cascade',
                    ),
                    'required' => true,
                    'invalid_message' => 'app.form.teamsAndProjects.edit.validation.internationalNameLanguage.choice',
                )
            )
            ->add(
                'international_name',
                TextType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.internationalName',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control-text col-xs-11 required rbins-int-name',
                        'data-cascade-field-class' => '.rbins-name-cascade',
                    ),
                    'required' => true,
                )
            )
            ->add(
                'international_description',
                TextareaType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.internationalDescription',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control col-xs-11 rbins-int-descr',
                        'data-cascade-field-class' => '.rbins-name-cascade',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'international_cascade',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'form.teamsAndProjects.internationalCascade.0' => 0,
                        'form.teamsAndProjects.internationalCascade.1' => 1,
                        'form.teamsAndProjects.internationalCascade.2' => 2,
                    ),
                    'choice_translation_domain' => 'content-db',
                    'label' => 'app.form.teamsAndProjects.edit.internationalCascade',
                    'label_attr' => array(
                        'class' => 'col-xs-11 col-form-label text-xs-left',
                    ),
                    'attr' => array(
                        'class' => 'form-control col-xs-11 required rbins-name-cascade',
                        'data-target' => '#rbins-localized-names',
                        'data-language-source' => '.rbins-language-source'
                    ),
                    'required' => true,
                    'invalid_message' => 'app.form.teamsAndProjects.edit.validation.internationalNameCascade.choice',
                )
            )
            ->add(
                'name_en',
                TextType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.nameEn',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control-text col-xs-11',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'description_en',
                TextareaType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.descriptionEn',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control col-xs-11',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'name_nl',
                TextType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.nameNl',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control-text col-xs-11',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'description_nl',
                TextareaType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.descriptionNl',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control col-xs-11',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'name_fr',
                TextType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.nameFr',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control-text col-xs-11',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'description_fr',
                TextareaType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.descriptionFr',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'form-control col-xs-11',
                    ),
                    'required' => false,
                )
            )
            ->add(
                'start_date',
                DateType::class,
                array(
                    'choice_translation_domain' => 'messages',
                    'required' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                    'placeholder' => 'app.form.teamsAndProjects.edit.date.placeholder',
                    'format' => 'dd/MM/yyyy',
                    'label' => 'app.form.teamsAndProjects.edit.startDate',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-xl-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'js-datepicker form-control-date'
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
                    'label' => 'app.form.teamsAndProjects.edit.endDate',
                    'label_attr' => array(
                        'class' => 'col-xs-4 col-sm-3 col-md-2 col-form-label text-xs-right',
                    ),
                    'attr' => array(
                        'class' => 'js-datepicker form-control-date'
                    ),
                )
            )
            ->add(
                'reset',
                ResetType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.reset',
                    'attr' => array(
                        'class' => 'reset rbins-reset-btn pull-right'
                    ),
                )
            )
            ->add(
                'save',
                SubmitType::class,
                array(
                    'label' => 'app.form.teamsAndProjects.edit.save',
                    'attr' => array(
                        'class' => 'save rbins-save-btn pull-right'
                    ),
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'AppBundle\Entity\Projects')
        );
    }
}
