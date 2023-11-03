<?php

namespace App\Controller\Admin;

use App\Entity\Cocktail;
use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class CocktailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cocktail::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Cocktails')
            ->setEntityLabelInSingular('Cocktail')
            ->setPageTitle("index", "Gestion des cocktails");
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled()->onlyWhenUpdating()->hideOnindex(),
            TextField::new('name'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category'),
            AssociationField::new('ingredient'),
            IntegerField::new('alcoolIndex')

        ];
    }
}
