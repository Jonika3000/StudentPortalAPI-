<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GradeRangeAdmin extends AbstractAdmin
{
    public function canCreate($object): bool
    {
        return false;
    }

    protected function configureActionButtons(array $buttonList, $action, $object = null): array
    {
        if (isset($buttonList['create'])) {
            unset($buttonList['create']);
        }

        return $buttonList;
    }
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('min', null, [
                'label' => 'Minimum Grade',
            ])
            ->add('max', null, [
                'label' => 'Maximum Grade',
            ]);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('min', null, [
                'label' => 'Minimum Grade',
            ])
            ->add('max', null, [
                'label' => 'Maximum Grade',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                ],
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('min', null, [
                'label' => 'Minimum Grade',
            ])
            ->add('max', null, [
                'label' => 'Maximum Grade',
            ]);
    }
}
