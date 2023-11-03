<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPageTitle("index", 'Gestion des utilisateurs');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled()->onlyWhenUpdating()->hideOnindex(),
            TextField::new('firstName')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            TextField::new('firstName')->onlyWhenCreating(),
            TextField::new('firstName')->onlyWhenUpdating()->setDisabled(),
            TextField::new('lastName')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            TextField::new('lastName')->onlyWhenCreating(),
            TextField::new('lastName')->onlyWhenUpdating()->setDisabled(),
            TextField::new('pseudo')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            TextField::new('pseudo')->onlyWhenCreating(),
            TextField::new('pseudo')->onlyWhenUpdating()->setDisabled(),
            EmailField::new('email')->setDisabled()->onlyWhenUpdating()->onlyOnIndex(),
            EmailField::new('email')->onlyWhenCreating(),
            EmailField::new('email')->onlyWhenUpdating()->setDisabled(),
            TextField::new('password')->setDisabled()->hideOnForm()->hideOnIndex(),
            TextField::new('password')->onlyWhenCreating(),
            ArrayField::new('roles'),
            BooleanField::new('isVerified'),
        ];
    }
}
