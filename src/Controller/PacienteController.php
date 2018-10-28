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
        $paciente = $pacienteService->create();
        $form = $this->createForm(NewPacienteType::class, $paciente);
        $error = false;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $pacienteService->register($paciente);

                    $this->addFlash('success', 'Paciente creado con éxito');

                    return $this->redirectToRoute('dashboard');
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
