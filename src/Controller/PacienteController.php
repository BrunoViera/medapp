<?php

namespace App\Controller;

use App\Entity\Paciente;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Exception;
use App\Service\PacienteService;
use App\Form\NewPacienteType;

/**
 * @Route("/paciente", name="paciente_")
 */

class PacienteController extends Controller
{

  /**
   * @Route("/add", name="add")
   *
   * @param Request $request
   *
   * @return Response
   */
    public function new(PacienteService $pacienteService, Request $request)
    {
        // build the form
        $paciente = $pacienteService->create();
        $form = $this->createForm(NewPacienteType::class, $paciente);
        $error = false;

        // handle the submit
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    // register the user
                    $pacienteService->register($paciente);

                    // send notification email
                    // $this->get('mailer_service')->sendEmail(
                    //     'Registro Correcto',
                    //     [$doctor->getEmail() => $doctor->getName()],
                    //     'site/registration/email/_register.html.twig',
                    //     ['user' => $doctor]
                    // );

                    $success = 'Usuario creado con éxito';
                    return $this->render('site/dashboard.html.twig', [
                        'success' => $success,
                    ]);
                } catch (Exception $e) {
                    $error = 'Se produjo un error al realizar el registro del paciente, por favor intente nuevamente.';
                }
            } else {
                $error = 'Se produjo un error al realizar el registro del paciente, por favor intente nuevamente.';
            }
        }

        return $this->render('paciente/new.html.twig', [
          'form' => $form->createView(),
          'error' => $error,
        ]);
    }
}
