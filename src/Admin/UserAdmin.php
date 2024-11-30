<?php

namespace App\Admin;

use App\Enums\Gender;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('firstName', TextType::class)
            ->add('secondName', TextType::class)
            ->add('birthday', DateTimeType::class)
            ->add('email', EmailType::class)
            ->add('phoneNumber', TextType::class)
            ->add('password', TextType::class)
            ->add('address', TextType::class)
            ->add('gender', EnumType::class, [
                'class' => Gender::class,
                'label' => 'gender',
                'attr' => ['data-sonata-select2' => 'true'],
            ])
            // ->add('gender', ChoiceType::class, ['choices' => Gender::getLabel()])
        ;
    }
}