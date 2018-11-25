<?php

namespace App\Controller;

use App\Service\PrescriptionService;
use App\Form\PrescriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prescripcion", name="prescription_")
 */
class PrescriptionController extends Controller
{
    /**
     * @Route("/add", name="add")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(PrescriptionService $prescriptiontService, Request $request)
    {
        $prescription = $prescriptiontService->create();
        $form = $this->createForm(PrescriptionType::class, $prescription);
        $error = false;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $prescriptiontService->save($prescription);

                    $this->addFlash('success', 'Medicación asignada');
                } catch (Exception $e) {
                    $error = 'Se produjo un error al realizar la prescripción, por favor intente nuevamente.';
                }
            } else {
                $error = 'Se produjo un error al realizar la prescripción, por favor intente nuevamente.';
            }
        }
        if ($error) {
            $this->addFlash('error', $error);
        }

        return $this->render('medicalPathient/show.html.twig', [
          'paciente' => $prescription->getMedicalPatient(),
          'prescriptionForm' => $form->createView(),
        ]);
    }
}
