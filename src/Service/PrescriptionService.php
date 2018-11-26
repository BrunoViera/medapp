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
    const PRESCRIPTION_CLASS_MED_INTERNA = 'Med. Interna';
    const PRESCRIPTION_CLASS_PSIQUIATRIA = 'Psiquiatría';
    const PRESCRIPTION_CLASS_NEUMOLOGIA = 'Neumología';
    const PRESCRIPTION_CLASS_DERMATOLOGIA = 'Dermatología';
    const PRESCRIPTION_CLASS_HEMATOLOGIA = 'Hematología';
    const PRESCRIPTION_CLASS_REUMATOLOGIA = 'Reumatología';

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
            self::PRESCRIPTION_CLASS_MED_INTERNA => 5,
            self::PRESCRIPTION_CLASS_PSIQUIATRIA => 6,
            self::PRESCRIPTION_CLASS_NEUMOLOGIA => 7,
            self::PRESCRIPTION_CLASS_DERMATOLOGIA => 8,
            self::PRESCRIPTION_CLASS_HEMATOLOGIA => 9,
            self::PRESCRIPTION_CLASS_REUMATOLOGIA => 10,
        ];
    }

    /**
     * return the name of a prescription class by the identifier
     *
     * @param int $classIdentifier
     * @return array
     */
    public function getClassName($classIdentifier)
    {
        switch ($classIdentifier) {
            case 1:
                return self::PRESCRIPTION_CLASS_CVASCULAR;
                break;
            case 2:
                return self::PRESCRIPTION_CLASS_DIGESTIVO;
                break;
            case 3:
                return self::PRESCRIPTION_CLASS_NEUROLOGICO;
                break;
            case 4:
                return self::PRESCRIPTION_CLASS_UROLOGICO;
                break;
            case 5:
                return self::PRESCRIPTION_CLASS_MED_INTERNA;
                break;
            case 6:
                return self::PRESCRIPTION_CLASS_PSIQUIATRIA;
                break;
            case 7:
                return self::PRESCRIPTION_CLASS_NEUMOLOGIA;
                break;
            case 8:
                return self::PRESCRIPTION_CLASS_DERMATOLOGIA;
                break;
            case 9:
                return self::PRESCRIPTION_CLASS_HEMATOLOGIA;
                break;
            case 10:
                return self::PRESCRIPTION_CLASS_REUMATOLOGIA;
                break;

            default:
                return '';
                break;
        }
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
