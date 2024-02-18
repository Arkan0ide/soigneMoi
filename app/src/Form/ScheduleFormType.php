<?php

namespace App\Form;

use App\Entity\Doctors;
use App\Entity\Patients;
use App\Entity\Schedule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTimeBegin', dateTimeType::class, [
                'label' => 'Horaire de début du rendez-vous',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateTimeEnd', dateTimeType::class, [
                'label' => 'Horaire de fin du rendez-vous',
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
            ->add('patient', EntityType::class, [
                'class' => Patients::class,
                'choice_label' => function (Patients $patient) {
                    return $patient->getUser()->getFirstname() . ' ' . $patient->getUser()->getLastname();
                },
                'label' => 'Patient',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
