<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Articles')
            ->setEntityLabelInSingular('Article')
            ->setPageTitle("index", 'Gestion des articles');
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
            AssociationField::new('author', 'Auteur')->hideOnForm(),
            TextField::new('title', 'Titre')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            TextField::new('title', 'Titre')->onlyWhenCreating(),
            TextField::new('title', 'Titre')->onlyWhenUpdating()->setDisabled(),
            TextField::new('slug')->hideOnForm()->hideOnIndex(),
            ImageField::new('imageName', 'Image')
                ->onlyOnIndex()
                ->setBasePath('/images/posts')->hideOnForm(),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyWhenUpdating()->setDisabled(),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyWhenCreating(),
            TextField::new('content', 'Contenu')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            TextEditorField::new('content', 'Contenu')->onlyWhenCreating(),
            TextField::new('content', 'Contenu')->onlyWhenUpdating()->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('createdAt', 'Crée le')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Mis à jour le ')->hideOnForm(),
            IntegerField::new('imageSize')->hideOnForm()->hideOnIndex(),
        ];
    }
}
