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
            TextField::new('name', 'Nom'),
            TextField::new('price', 'Prix'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('ingredient', 'Ingrédient'),
            AssociationField::new('link', 'Lien vers l\'article'),
            IntegerField::new('alcoolIndex', 'Taux d\'alcool')

        ];
    }
}
