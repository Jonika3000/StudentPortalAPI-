<?php

namespace App\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

class TeacherAdmin extends AbstractAdmin
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        parent::__construct();
    }

    public function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('User data', ['class' => 'col-md-6'])
            ->add('associatedUser', ModelType::class, [
                'query' => $this->userRepository->getFilteredUsersQuery(),
                'required' => false,
                'label' => 'Associated User',
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
            ]);
    }
}
