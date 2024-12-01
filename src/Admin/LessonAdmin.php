<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

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
            ->add('classroom.uuid', null, ['label' => 'Classroom']);
    }
}
