<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use phpDocumentor\Reflection\Types\Integer;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Réservations')
            ->setEntityLabelInSingular('Réservation')
            ->setPageTitle("index", "Gestion des réservation");
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled()->onlyWhenUpdating()->hideOnindex(),
            TextField::new('numTel'),
            TextField::new('author.email'),
            IntegerField::new('nbrPeople'),
            TextField::new('specialAsk'),
            DateTimeField::new('bookedAt', 'Pour le'),
            DateTimeField::new('createdAt', 'Demande faite à'),
        ];
    }
}
