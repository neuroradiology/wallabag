<?php

namespace Wallabag\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'user.form.name_label',
            ])
            ->add('username', TextType::class, [
                'required' => true,
                'label' => 'user.form.username_label',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'user.form.email_label',
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'label' => 'user.form.enabled_label',
            ])
            ->add('emailTwoFactor', CheckboxType::class, [
                'required' => false,
                'label' => 'user.form.twofactor_email_label',
            ])
            ->add('googleTwoFactor', CheckboxType::class, [
                'required' => false,
                'label' => 'user.form.twofactor_google_label',
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'user.form.save',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Wallabag\UserBundle\Entity\User',
        ]);
    }
}
