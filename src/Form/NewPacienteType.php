<?php

namespace App\Form;

use App\Entity\Paciente;
use App\Service\PacienteService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class NewPacienteType extends AbstractType
{
    protected $genderList;

    /**
     * NewPacienteType constructor.
     *
     * @param PacienteService $pacienteService
     */
    public function __construct(PacienteService $pacienteService)
    {
        $this->genderList = $pacienteService->getGenderList();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                ['attr' => ['placeholder' => 'Nombre'], 'required' => true, 'label' => 'Nombre']
            )
            ->add(
                'lastName',
                TextType::class,
                ['attr' => ['placeholder' => 'Apellidos'], 'required' => true, 'label' => 'Apellidos']
            )
            ->add(
                'personalId',
                TextType::class,
                ['attr' => ['placeholder' => 'Teléfono'], 'label' => 'Teléfono']
            )
            ->add(
                'gender',
                ChoiceType::class,
                array_merge(['choices' => $this->genderList, 'label' => 'Género'])
            )
            ->add(
                'birthday',
                DateTimeType::class,
                [
                    'html5' => false,
                    'required' => false,
                    'label' => 'Fecha de nacimiento',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'placeholder' => 'dd/mm/YYYY'
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                ['attr' => ['placeholder' => '50.6'], 'label' => 'Peso del paciente']
            )
            ->add(
                'height',
                NumberType::class,
                ['attr' => ['placeholder' => '1.78'], 'label' => 'Altura del paciene']
            )
            ->add(
                'send',
                SubmitType::class,
                ['attr' =>
                    ['class' => 'btn btn-block btn-primary mt-3'],
                    'label' => 'Registrar Paciente'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Paciente::class]);
    }
}
