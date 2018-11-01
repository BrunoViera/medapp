<?php

namespace App\Form;

use App\Entity\Doctor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

class DoctorRegistrationType extends AbstractType
{
    protected $encoder;

    /**
     * RegistrationUserType constructor.
     *
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
                'email',
                EmailType::class,
                ['attr' => ['placeholder' => 'Email'], 'required' => true, 'label' => 'Email']
            )
            ->add(
                'phone',
                TextType::class,
                ['attr' => ['placeholder' => 'Teléfono'], 'label' => 'Teléfono']
            )
            ->add(
                'personalId',
                IntegerType::class,
                ['attr' => ['placeholder' => '1.234.567-8'], 'label' => 'Cédula de Identidad']
            )
            ->add(
                'profesionalInput',
                TextType::class,
                ['attr' => ['placeholder' => '1234567890'], 'label' => 'Número de Caja de los profesionales']
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'mapped' => false,
                    'type' => PasswordType::class,
                    'invalid_message' => 'Las claves deben coincidir',
                    'first_options' => ['attr' => ['placeholder' => 'Contraseña'], 'label' => 'Contraseña'],
                    'second_options' => [
                        'attr' => ['placeholder' => 'Confirma la contraseña'],
                        'label' => 'Repita la contraseña'],
                    'required' => true
                ]
            )
            ->add('send', SubmitType::class, ['attr' => ['class' => 'btn btn-block btn-primary mt-3'], 'label' => 'Registrarme']);


        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $doc = $event->getForm()->getData();

                $newPassword = $event->getForm()->get('password')->getData();
                if (strlen($newPassword) < 8) {
                    $event->getForm()->addError(new FormError('La contraseña debe ser mayor a 8 caracteres.'));
                    return;
                }

                $newPassword = $this->encoder->encodePassword($doc, $newPassword);
                $doc->setPassword($newPassword);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Doctor::class]);
    }
}
