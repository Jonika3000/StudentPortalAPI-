<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;

class TeacherAdmin extends AbstractAdmin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('User data', ['class' => 'col-md-6'])
            ->add('associatedUser', AdminType::class, [
                'required' => true,
                'label' => 'Associated User',
            ])
            ->end()
            ->with('Lessons', ['class' => 'col-md-6'])
            ->add('lesson', ModelType::class, [
                'multiple' => true,
                'required' => false,
                'label' => 'Lessons',
            ])
            ->end();
    }

    public function configureListFields(ListMapper $list): void
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
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'show' => [],
                ],
                'label' => 'Actions',
            ]);
    }

    public function configureShowFields(ShowMapper $show): void
    {
        $show
            ->with('Teacher Details')
            ->add('associatedUser.avatarPath', null, [
                'template' => 'admin/image_preview.html.twig',
                'label' => 'Avatar',
                'path' => $this->getSubjectAssociatedUserAvatarPath(),
            ])
            ->add('id', null, [
                'label' => 'ID',
            ])
            ->add('associatedUser.email', null, [
                'label' => 'Email',
            ])
            ->add('associatedUser.firstName', null, [
                'label' => 'First Name',
            ])
            ->add('associatedUser.secondName', null, [
                'label' => 'Second Name',
            ])
            ->add('associatedUser.birthday', null, [
                'label' => 'Birthday',
            ])
            ->add('associatedUser.address', null, [
                'label' => 'Address',
            ])
            ->add('associatedUser.phoneNumber', null, [
                'label' => 'Phone Number',
            ])
            ->add('associatedUser.gender', null, [
                'label' => 'Gender',
            ])
            ->end()
            ->with('Homework Assigned')
            ->add('homework', null, [
                'label' => 'Homework',
                'associated_property' => 'title',
            ])
            ->end()
            ->with('Lessons Taught')
            ->add('lesson', null, [
                'label' => 'Lessons',
                'associated_property' => 'name',
            ])
            ->end();
    }

    public function getSubjectAssociatedUserAvatarPath(): ?string
    {
        $user = $this->getSubject()->getAssociatedUser();

        return $user ? $user->getAvatarPath() : null;
    }
}
