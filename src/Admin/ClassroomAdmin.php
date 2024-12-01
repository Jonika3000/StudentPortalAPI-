<?php

namespace App\Admin;

use App\Entity\Lesson;
use App\Entity\Student;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

class ClassroomAdmin extends AbstractAdmin
{
    public function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Students', ['class' => 'col-md-6'])
            ->add('students', ModelType::class, [
                'class' => Student::class,
                'multiple' => true,
                'label' => 'Students',
                'required' => true,
                'help' => 'Select students to assign to this classroom.',
            ])
            ->end()
            ->with('Lessons', ['class' => 'col-md-6'])
            ->add('lessons', ModelType::class, [
                'class' => Lesson::class,
                'multiple' => true,
                'label' => 'Lessons',
                'required' => false,
                'help' => 'Select lessons to assign to this classroom.',
            ])
            ->end();
    }

    public function configureListFields(ListMapper $list): void
    {
        $list
            ->add('uuid', null, [
                'label' => 'Indicator',
            ])
            ->add('createdAt', null, [
                'label' => 'Created',
            ]);
    }
}
