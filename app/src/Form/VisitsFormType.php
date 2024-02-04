<?php

namespace App\Form;

use App\Entity\Doctors;
use App\Entity\Patients;
use App\Entity\Specialities;
use App\Entity\Visits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', dateType::class, [
                'label' => 'Date de début du séjour',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('EndDate', dateType::class, [
                'label' => 'Date de fin du séjour',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('reason', TextType::class, [
                'label' => 'Motif de la visite',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('doctor', EntityType::class, [
                'class' => Doctors::class,
                'choice_label' => function (Doctors $doctor) {
                    return $doctor->getUser()->getFirstname() . ' ' . $doctor->getUser()->getLastname();
                },
                'label' => 'Médecin',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('speciality', EntityType::class, [
                'class' => Specialities::class,
                'choice_label' => 'name',
                'label' => 'Spécialité',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visits::class,
        ]);
    }
}
