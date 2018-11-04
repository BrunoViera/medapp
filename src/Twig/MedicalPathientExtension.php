<?php

namespace App\Twig;

use App\Service\MedicalPathientService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MedicalPathientExtension extends AbstractExtension
{
    protected $MedicalPathientService;

    public function __construct(MedicalPathientService $medicalPathientService)
    {
        $this->medicalPathientService = $medicalPathientService;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('gender_name', [$this, 'getGenderName']),
        ];
    }

    /**
     * @param int gender
     * @return string
     */
    public function getGenderName(int $gender)
    {
        return $this->medicalPathientService->getGenderName($gender);
    }
}
