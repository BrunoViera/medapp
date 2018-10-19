<?php

namespace App\Controller;

use App\Entity\Doctor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Exception;
use App\Service\DoctorService;
use App\Form\DoctorRegistrationType;

/**
 * @Route("/", name="doctor_")
 */
class DoctorController extends Controller
{
    // private $doctorService;

    // public function __construct(DoctorService $doctorService)
    // {
    //     $this->doctorService = $doctorService;
    // }

    /**
     * @Route("/registro", name="registration")
     *
     * @param Request $request
     * @param AuthorizationCheckerInterface $authChecker
     *
     * @return Response
     */
    public function register(DoctorService $docService, Request $request, AuthorizationCheckerInterface $authChecker)
    {
        // if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
        //     return $this->redirectToRoute('homepage');
        // }

        // build the form
        $doctor = $docService->create();
        $form = $this->createForm(DoctorRegistrationType::class, $doctor);

        //handle the submit
        // $form->handleRequest($request);
        // if ($form->isSubmitted()) {
        //     if ($form->isValid()) {
        //         try {
        //             // register the user
        //             $this->getService()->register($user);

        //             // send notification email
        //             $this->get('mailer_service')->sendEmail(
        //                 'Registro Correcto',
        //                 [$user->getEmail() => $user->getName()],
        //                 'site/registration/email/_register.html.twig',
        //                 ['user' => $user]
        //             );

        //             return $this->redirectToRoute('user_registration_successful');
        //         } catch (Exception $e) {
        //             $error = 'Se produjo un error al realizar el registro, por favor intente nuevamente.';
        //         }
        //     } else {
        //         $error = 'Se produjo un error al realizar el registro, por favor intente nuevamente.';
        //     }
        // }

        return $this->render('Doctor/registration.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}
