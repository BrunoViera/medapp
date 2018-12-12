<?php

namespace App\Controller;

use App\Form\PrescriptionType;
use App\Service\PrescriptionService;
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

        return $this->render('medicalPathient/show.html.twig', [
            'paciente' => $medicalPathient,
            'view' => 'PRESCRIPTIONS',
            'status' => true,
        ]);
    }

    /**
     * @Route("/edit/{personalId}", name="edit")
     *
     * @param string $personalId
     *
     * @return Response
    */
    public function edit(MedicalPathientService $medicalPathientService, string $personalId)
    {
        $medicalPathient = $medicalPathientService->getByAttribute(['personalId' => $personalId]);

        if (!$medicalPathient instanceof MedicalPathient) {
            $this->addFlash('error', sprintf('El paciente con la cédula %s, no existe en el sistema', $personalId));
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->createForm(NewMedicalPathientType::class, $medicalPathient);


        return $this->render('medicalPathient/show.html.twig', [
          'paciente' => $medicalPathient,
          'view' => 'EDIT',
          'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recetas/activas/{personalId}", name="prescriptions_enable")
     *
     * @param string $personalId
     *
     * @return Response
    */
    public function prescriptionsEnable(MedicalPathientService $medicalPathientService, string $personalId)
    {
        $medicalPathient = $medicalPathientService->getByAttribute(['personalId' => $personalId]);

        if (!$medicalPathient instanceof MedicalPathient) {
            $this->addFlash('error', sprintf('El paciente con la cédula %s, no existe en el sistema', $personalId));
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('medicalPathient/show.html.twig', [
          'paciente' => $medicalPathient,
          'view' => 'PRESCRIPTIONS',
          'status' => true,
        ]);
    }

    /**
     * @Route("/recetas/previas/{personalId}", name="prescriptions_disable")
     *
     * @param string $personalId
     *
     * @return Response
    */
    public function prescriptionsDisable(MedicalPathientService $medicalPathientService, string $personalId)
    {
        $medicalPathient = $medicalPathientService->getByAttribute(['personalId' => $personalId]);

        if (!$medicalPathient instanceof MedicalPathient) {
            $this->addFlash('error', sprintf('El paciente con la cédula %s, no existe en el sistema', $personalId));
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('medicalPathient/show.html.twig', [
          'paciente' => $medicalPathient,
          'view' => 'PRESCRIPTIONS',
          'status' => false,
        ]);
    }

    /**
     * @Route("/recetas/nueva/{personalId}", name="prescription_new")
     *
     * @param string $personalId
     *
     * @return Response
     */
    public function prescriptionsNew(
        MedicalPathientService $medicalPathientService,
        PrescriptionService $prescriptiontService,
        string $personalId,
        Request $request
    ) {
        $medicalPathient = $medicalPathientService->getByAttribute(['personalId' => $personalId]);
        $prescription = $prescriptiontService->create();

        $form = $this->createForm(PrescriptionType::class, $prescription);
        $error = false;

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    try {
                        $prescriptiontService->save($prescription);

                        $this->addFlash('success', 'Medicación asignada');
                        return $this->render('medicalPathient/show.html.twig', [
                            'paciente' => $medicalPathient,
                            'view' => 'PRESCRIPTIONS',
                            'status' => true
                            ]);
                    } catch (Exception $e) {
                        $error = 'Se produjo un error al realizar la prescripción, por favor intente nuevamente.';
                    }
                } else {
                    $error = 'Se produjo un error al realizar la prescripción, por favor intente nuevamente.';
                }
            }

            $this->addFlash('error', $error);
        } else {
            $prescription->setMedicalPatient($medicalPathient);
            $prescription->setDoctor($this->getUser());
            $prescriptionForm = $this->createForm(PrescriptionType::class, $prescription);
        }


        return $this->render('medicalPathient/show.html.twig', [
          'paciente' => $medicalPathient,
          'view' => 'PRESCRIPTION_NEW',
          'status' => false,
          'form' => $form->createView(),
        ]);
    }
}
