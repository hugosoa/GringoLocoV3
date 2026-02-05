<?php

namespace App\Form;

use App\Entity\Cocktail;
use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\MakerBundle\Doctrine\RelationOneToMany;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PictureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Ajouter une image',
                'required' => true,
                'allow_delete' => true,
                'delete_label' => 'Supprimer',
                //'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
                //'imagine_pattern' => '...',
                'asset_helper' => true,
            ])
            ->add('cocktailName', EntityType::class, [
                'class' => Cocktail::class,
                'label' => 'Nom du cocktail',
                'placeholder' => 'Sélectionnez un cocktail',
                'required' => false,
            ])
            ->add('Ajouter', SubmitType::class, [
                // 'attr' => [
                //     'class' => 'form__button',
                // ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}
