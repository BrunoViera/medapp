<?php

namespace App\Service;

use App\Entity\Prescription;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PrescriptionService
{
    const PRESCRIPTION_CLASS_CVASCULAR = 'Cardio Vascular';
    const PRESCRIPTION_CLASS_DIGESTIVO = 'Digestivo';
    const PRESCRIPTION_CLASS_NEUROLOGICO = 'Neurológico';
    const PRESCRIPTION_CLASS_UROLOGICO = 'Urológico';

    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:Prescription');
    }

    /**
     * return a list of class predictions
     *
     * @return array
     */
    public function getClassList()
    {
        return [
            self::PRESCRIPTION_CLASS_CVASCULAR => 1,
            self::PRESCRIPTION_CLASS_DIGESTIVO => 2,
            self::PRESCRIPTION_CLASS_NEUROLOGICO => 3,
            self::PRESCRIPTION_CLASS_UROLOGICO => 4,
        ];
    }

    /**
     * @return Prescription
     */
    public function create()
    {
        return new Prescription();
    }

    public function save(Prescription $prescription)
    {
        $this->em->persist($prescription);
        $this->em->flush();

        return $prescription;
    }

    /**
     * @param Prescription $prescription
     *
     * @return Prescription
     */
    public function edit(Prescription $prescription)
    {
        $this->em->flush();

        return $prescription;
    }

    /**
     * @param array $attribute
     *
     * @return Prescription
     */
    public function getByAttribute(array $attribute)
    {
        return $this->repository->findOneBy($attribute);
    }
}
