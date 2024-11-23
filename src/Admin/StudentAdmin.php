<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class StudentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('User data', ['class' => 'col-md-6'])
            ->add('associatedUser', ModelType::class)
            ->end()
            ->with('Student data', ['class' => 'col-md-6'])
            ->add('contactParent', TextType::class)
            ->end();
    }
}
