<?php

namespace App\Form;

use App\Entity\MedicalPathient;
use App\Service\MedicalPathientService;
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

class MedicalPathientType extends AbstractType
{
    protected $genderList;

    /**
     * MedicalPathientType constructor.º
     *
     * @param MedicalPathientService $medicalPathientService
     */
    public function __construct(MedicalPathientService $medicalPathientService)
    {
        $this->genderList = $medicalPathientService->getGenderList();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['data']->getId();
        if (isset($id)) {
            $btnTxt = 'Guardar';
        } else {
            $btnTxt = 'Registrar Paciente';
        }

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
                ['attr' => ['placeholder' => '1.234.567-8'], 'label' => 'Cédula de Identidad']
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
                    'attr' => ['placeholder' => 'dd/MM/YYYY'],
                    'html5' => true,
                    'required' => false,
                    'label' => 'Fecha de nacimiento',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                ['attr' => ['placeholder' => '50.6'], 'label' => 'Peso (Kg)', 'required' => false]
            )
            ->add(
                'height',
                NumberType::class,
                ['attr' => ['placeholder' => '178'], 'label' => 'Altura (cm)', 'required' => false]
            )
            ->add(
                'send',
                SubmitType::class,
                ['attr' =>
                    ['class' => 'btn btn-block btn-primary mt-3'],
                    'label' => $btnTxt
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => MedicalPathient::class]);
    }
}
