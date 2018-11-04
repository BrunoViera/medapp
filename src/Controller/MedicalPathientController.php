<?php

namespace App\Controller;

use App\Form\PrescriptionType;
use App\Entity\MedicalPathient;
use App\Entity\Prescription;
use App\Form\NewMedicalPathientType;
use App\Service\MedicalPathientService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Exception;

/**
 * @Route("/paciente", name="paciente_")
 */
class MedicalPathientController extends Controller
{

  /**
   * @Route("/add", name="add")
   *
   * @param Request $request
   *
   * @return Response
   */
    public function new(MedicalPathientService $medicalPathientService, Request $request)
    {
        $medicalPathient = $medicalPathientService->create();
        $form = $this->createForm(NewMedicalPathientType::class, $medicalPathient);
        $error = false;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $medicalPathientService->register($medicalPathient);

                    $this->addFlash('success', 'Paciente creado con éxito');

                    return $this->redirectToRoute('dashboard');
                } catch (Exception $e) {
                    $error = 'Se produjo un error al realizar el registro del paciente, por favor intente nuevamente.';
                }
            } else {
                $error = 'Se produjo un error al realizar el registro del paciente, por favor intente nuevamente.';
            }
        }

        return $this->render('medicalPathient/new.html.twig', [
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
    public function search(MedicalPathientService $medicalPathientService, Request $request)
    {
        $personalId = $request->get('personalId', 0);
        $medicalPathient = $medicalPathientService->getByAttribute(['personalId' => $personalId]);

        if (!$medicalPathient instanceof MedicalPathient) {
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
    public function show(MedicalPathientService $medicalPathientService, string $personalId)
    {
        $medicalPathient = $medicalPathientService->getByAttribute(['personalId' => $personalId]);

        if (!$medicalPathient instanceof MedicalPathient) {
            $this->addFlash('error', sprintf('El paciente con la cédula %s, no existe en el sistema', $personalId));
            return $this->redirectToRoute('dashboard');
        }

        $formSubmit = $this->generateUrl('prescription_add');
        $prescription = new Prescription();
        $prescription->setMedicalPatient($medicalPathient);
        $prescription->setDoctor($this->getUser());
        $prescriptionForm = $this->createForm(PrescriptionType::class, $prescription, ['action' => $formSubmit]);

        return $this->render('medicalPathient/show.html.twig', [
          'paciente' => $medicalPathient,
          'prescriptionForm' => $prescriptionForm->createView(),
        ]);
    }
}
