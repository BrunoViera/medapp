<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Service\MedicineService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
  * @Route("/medicamento", name="medicamento_")
 */
class MedicineController extends Controller
{

    /**
     * @Route("/search", name="search", methods="GET")
     */
    public function search(Request $request, MedicineService $medicineService):JsonResponse
    {
        try {
            $name = $request->get('name', '');
            $data = $medicineService->search($name);

            return new JsonResponse($data, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
