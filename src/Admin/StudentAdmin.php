<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class StudentAdmin extends AbstractAdmin
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('User data', ['class' => 'col-md-6'])
            ->add('associatedUser', AdminType::class, [
                'required' => false,
                'label' => 'Associated User',
            ])
            ->end()
            ->with('Student data', ['class' => 'col-md-6'])
            ->add('contactParent', TextType::class)
            ->end();
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('associatedUser.email', null, [
                'label' => 'Email',
            ])
            ->add('associatedUser.firstName', null, [
                'label' => 'First name',
            ])
            ->add('associatedUser.secondName', null, [
                'label' => 'Second name',
            ])
            ->add('associatedUser.birthday', null, [
                'label' => 'Birthday',
            ])
        ;
    }
}
