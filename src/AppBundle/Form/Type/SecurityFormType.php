<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SecurityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add(
            '_username',
            TextType::class,
            array(
                'label' => 'login.user_label',
                'translation_domain' => 'security'
            )
        )
        ->add(
            '_password',
            PasswordType::class,
            array(
                'label' => 'login.pwd_label',
                'translation_domain' => 'security'
            )
        );
    }
}
