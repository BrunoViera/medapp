<?php

namespace App\Form;

use App\Entity\Prescription;
use App\Entity\Medicine;
use App\Service\PrescriptionService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescriptionType extends AbstractType
{
    protected $classList;

    /**
     * prescriptionType constructor.
     *
     * @param PrescriptionService $prescriptionService
     */
    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->classList = $prescriptionService->getClassList();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('doctor', null, ['attr' => ['hidden' => true], 'label' => false])
            ->add('medicalPatient', null, ['attr' => ['hidden' => true], 'label' => false])
            ->add(
                'medicine',
                EntityType::class,
                array_merge([
                    'placeholder' => 'Seleccione un medicamento',
                    'class' => Medicine::class,
                    'label' => 'Medicamento',
                    'required' => true
                    ])
            )
            ->add(
                'class',
                ChoiceType::class,
                array_merge([
                    'placeholder' => 'Seleccione la clase de medicamento',
                    'choices' => $this->classList,
                    'label' => 'Clase',
                    'required' => true
                    ])
            )
            ->add(
                'dose',
                TextType::class,
                ['attr' => ['placeholder' => '1 píldora'], 'required' => true, 'label' => 'Dósis']
            )
            ->add(
                'frequency',
                TextType::class,
                ['attr' => ['placeholder' => 'cada 8 horas'], 'required' => true, 'label' => 'Frecuencia']
            )
            ->add(
                'description',
                TextareaType::class,
                ['required' => false, 'label' => 'Descripción']
            )
            ->add(
                'startAt',
                DateTimeType::class,
                [
                    'attr' => ['placeholder' => 'dd/MM/YYYY'],
                    'html5' => true,
                    'required' => false,
                    'label' => 'Fecha de inicio del tratamiento',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'data' => new \Datetime(),
                ]
            )
            ->add(
                'endsAt',
                DateTimeType::class,
                [
                    'attr' => ['placeholder' => 'dd/MM/YYYY'],
                    'html5' => true,
                    'required' => false,
                    'label' => 'Fecha de final del tratamiento',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                ['attr' =>
                    ['class' => 'btn btn-block btn-primary mt-3'],
                    'label' => 'Agregar Medicación'
                ]
            )
            ->add(
                'cancel',
                ButtonType::class,
                ['attr' =>
                    ['class' => 'btn btn-block btn-danger mt-3 js-add_medication'],
                    'label' => 'Cancelar'
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
