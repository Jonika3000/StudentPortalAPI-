<?php

namespace App\Admin;

use App\Entity\Subject;
use App\Utils\FileHelper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class SubjectAdmin extends AbstractAdmin
{
    private FileHelper $fileHelper;

    public function __construct(FileHelper $fileHelper)
    {
        parent::__construct();
        $this->fileHelper = $fileHelper;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('imagePath', FileType::class, [
                'required' => false,
                'mapped' => false,
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('description')
            ->add('imagePath', null, [
                'template' => 'admin/image_preview.html.twig',
            ]);
    }

    protected function prePersist(object $object): void
    {
        $this->manageFileUpload($object);
    }

    protected function preUpdate(object $object): void
    {
        $this->manageFileUpload($object);
    }

    private function manageFileUpload(Subject $subject): void
    {
        /** @var UploadedFile|null $file */
        $file = $this->getForm()->get('imagePath')->getData();

        if ($file instanceof UploadedFile) {
            $path = $this->fileHelper->uploadImage($file, '/subject/', false);
            $subject->setImagePath($path);
        }
    }
}
