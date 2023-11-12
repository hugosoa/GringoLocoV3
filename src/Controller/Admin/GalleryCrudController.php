<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\DomCrawler\Field\FileFormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gallery::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::EDIT, Action::NEW);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled()->onlyWhenUpdating()->hideOnindex(),
            TextField::new('author', 'Auteur')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            TextField::new('author', 'Auteur')->onlyWhenCreating(),
            ImageField::new('imageName', 'Image')
                ->onlyOnIndex()
                ->setBasePath('/images/posts')->hideOnForm(),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyWhenUpdating()->setDisabled(),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyWhenCreating(),
            IntegerField::new('imageSize')->hideOnDetail()->hideOnForm()->hideOnIndex(),
            DateTimeField::new('createdAt', 'Crée le')->hideOnForm(),
            DateTimeField::new('updatedAt', "Mis à jour le")->hideOnForm()
        ];
    }
}
