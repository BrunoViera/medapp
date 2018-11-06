<?php

namespace App\Twig;

use App\Service\PrescriptionService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PrescriptionExtension extends AbstractExtension
{
    protected $PrescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('class_name', [$this, 'getClassName']),
        ];
    }

    /**
     * @param int class
     * @return string
     */
    public function getClassname(int $class)
    {
        return $this->prescriptionService->getClassName($class);
    }
}
