<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre Nom',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'required' => true
            ])
            ->add('object', TextType::class, [
                'label' => 'Objet',
                'required' => true
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre Message',
                'required' => true,
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('recaptcha', ReCaptchaType::class)
            
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer le Mail'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
