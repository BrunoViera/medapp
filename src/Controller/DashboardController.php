<?php

namespace App\Controller;

use App\Entity\Doctor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Exception;
use App\Service\DoctorService;
use App\Form\DoctorRegistrationType;

class DashboardController extends Controller
{

  /**
   * @Route("/", name="dashboard")
   *
   * @param Request $request
   *
   * @return Response
   */
    public function dashboard(Request $request)
    {
        return $this->render('site/dashboard.html.twig');
    }
}
