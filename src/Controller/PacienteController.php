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

    /**
     * @Route("/search", name="search")
     *
     * @param Request $request
     *
     * @return Response
    */
    public function search(PacienteService $pacienteService, Request $request)
    {
        $personalId = $request->get('personalId', 0);
        $paciente = $pacienteService->getByAttribute(['personalId' => $personalId]);

        if (!$paciente instanceof Paciente) {
            $this->addFlash('error', sprintf('El paciente con la cédula %s, no existe en el sistema', $personalId));
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('paciente_show', array('personalId' => $personalId));
    }

    /**
     * @Route("/{personalId}", name="show")
     *
     * @param string $personalId
     *
     * @return Response
    */
    public function show(PacienteService $pacienteService, string $personalId)
    {
        $paciente = $pacienteService->getByAttribute(['personalId' => $personalId]);

        if (!$paciente instanceof Paciente) {
            $this->addFlash('error', sprintf('El paciente con la cédula %s, no existe en el sistema', $personalId));
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('paciente/show.html.twig', [
          'paciente' => $paciente,
        ]);
    }
}
