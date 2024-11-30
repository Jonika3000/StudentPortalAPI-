<?php

namespace App\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class TeacherAdmin extends AbstractAdmin
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }
    public function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('User data', ['class' => 'col-md-6'])
            ->add('associatedUser', ModelType::class, [
                'query' => $this->getAvailableUsersQuery(),
                'required' => false,
                'label' => 'Associated User',
            ])
            ->end();
    }

    private function getAvailableUsersQuery(): ProxyQuery
    {
        $subqueryStudent = $this->entityManager->createQueryBuilder()
            ->select('IDENTITY(s.associatedUser)')
            ->from('App\Entity\Student', 's')
            ->getDQL();

        $subqueryTeacher = $this->entityManager->createQueryBuilder()
            ->select('IDENTITY(t.associatedUser)')
            ->from('App\Entity\Teacher', 't')
            ->getDQL();

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u')
            ->from('App\Entity\User', 'u')
            ->where(
                $qb->expr()->notIn('u.id', $subqueryStudent)
            )
            ->andWhere(
                $qb->expr()->notIn('u.id', $subqueryTeacher)
            );

        return new ProxyQuery($qb);
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
