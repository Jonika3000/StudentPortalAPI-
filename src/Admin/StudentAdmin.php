<?php

namespace App\Admin;

use App\Enums\Gender;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class StudentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('User data', ['class' => 'col-md-6'])
            ->add('associatedUser.firstName', TextType::class)
            ->add('associatedUser.secondName', TextType::class)
            ->add('associatedUser.birthday', DateTimeType::class)
            ->add('associatedUser.email', EmailType::class)
            ->add('associatedUser.phoneNumber', TextType::class)
            ->add('associatedUser.gender', ChoiceType::class, ['choices' => Gender::getLabel()])
            ->end()
            ->with('Student data', ['class' => 'col-md-6'])
            ->add('contactParent', TextType::class)
            ->end();
    }
}
