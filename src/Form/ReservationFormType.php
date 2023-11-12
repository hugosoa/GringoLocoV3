<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numTel', TextType::class, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('nbrPeople', ChoiceType::class, [
                'label' => 'Pour combien de personnes ?',
                'choices' => $this->generateNumberChoices(1, 15),
            ])
            ->add('bookedAt', DateTimeType::class, [
                'label' => 'Date et heure de la réservation',
                'widget' => 'choice',
                'input' => 'datetime_immutable',
                'years' => range(date('Y'), date('Y') + 1),
                'data' => new \DateTimeImmutable()

                // 'attr' => ['class' => 'datepicker'], // Ajoutez des classes CSS personnalisées si nécessaire
            ])
            ->add('specialAsk', TextareaType::class, [
                'label' => 'Demandes spécial',
                'required' => false
            ])
            ->add('Ajouter', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }

    private function generateNumberChoices(int $min, int $max): array
    {
        $choices = [];
        for ($i = $min; $i <= $max; $i++) {
            $choices[$i] = $i;
        }

        return $choices;
    }
}
