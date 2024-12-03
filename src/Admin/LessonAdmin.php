<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;

class LessonAdmin extends AbstractAdmin
{
    public function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Data')
            ->add('classroom', ModelType::class, [
                'label' => 'Classroom',
                'required' => true,
            ])
            ->add('subject', ModelType::class, [
                'label' => 'Subject',
                'required' => true,
            ])
            ->add('teachers', ModelType::class, [
                'label' => 'Teachers',
                'required' => true,
                'multiple' => true,
            ])
            ->end();
    }

    public function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('subject.name', null, ['label' => 'Subject'])
            ->add('classroom.uuid', null, ['label' => 'Classroom'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ]);
    }

    public function configureShowFields(ShowMapper $show): void
    {
        $show
            ->with('Lesson Details', ['class' => 'col-md-6'])
            ->add('id', null, [
                'label' => 'ID',
            ])
            ->add('subject', null, [
                'label' => 'Subject',
            ])
            ->add('classroom', null, [
                'label' => 'Classroom',
            ])
            ->end()
            ->with('Associated Homework', ['class' => 'col-md-6'])
            ->add('homework', null, [
                'label' => 'Homework',
                'associated_property' => 'description',
            ])
            ->end()
            ->with('Assigned Teachers', ['class' => 'col-md-6'])
            ->add('teachers', null, [
                'label' => 'Teachers',
                'associated_property' => 'associatedUser.secondName',
            ])
            ->end();
    }
}
