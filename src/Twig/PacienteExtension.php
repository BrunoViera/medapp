<?php

namespace App\Twig;

use App\Service\PacienteService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PacienteExtension extends AbstractExtension
{
    protected $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
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
        return $this->pacienteService->getGenderName($gender);
    }
}
