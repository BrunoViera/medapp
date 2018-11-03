<?php

namespace App\Service;

use App\Entity\MedicalPathient;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use DateTime;

class MedicalPathientService
{
    const MEDICALPATHIENT_GENDER_DESCONOCIDO = 'Desconocido';
    const MEDICALPATHIENT_GENDER_NO_APLICA = 'No Aplica';
    const MEDICALPATHIENT_GENDER_MASCULINO = 'Masculino';
    const MEDICALPATHIENT_GENDER_FEMENINO = 'Femenino';

    const MEDICALPATHIENT_REGISTER_ACTIVE = 1;
    const MEDICALPATHIENT_REGISTER_INACTIVE = 0;


    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:MedicalPathient');
    }

    /**
     * return a list of gender in an array
     *
     * @return array
     */
    public function getGenderList()
    {
        return [
            self::MEDICALPATHIENT_GENDER_FEMENINO => 1,
            self::MEDICALPATHIENT_GENDER_NO_APLICA => 2,
            self::MEDICALPATHIENT_GENDER_MASCULINO => 3,
            self::MEDICALPATHIENT_GENDER_DESCONOCIDO => 4,
        ];
    }

    /**
     * @param int $gender
     *
     * @return array
     */
    public function getGenderName($gender)
    {
        $name = '';
        switch ($gender) {
            case 1:
                $name = self::MEDICALPATHIENT_GENDER_FEMENINO;
                break;
            case 2:
                $name = self::MEDICALPATHIENT_GENDER_NO_APLICA;
                break;
            case 3:
                $name = self::MEDICALPATHIENT_GENDER_MASCULINO;
                break;
            case 4:
                $name = self::MEDICALPATHIENT_GENDER_DESCONOCIDO;
                break;
        };
        return $name;
    }

    /**
     * @return MedicalPathient
     */
    public function create()
    {
        $medicalPathient = new MedicalPathient();
        $medicalPathient->setIsActive(boolval(self::MEDICALPATHIENT_REGISTER_ACTIVE));

        return $medicalPathient;
    }

    /**
     * @param MedicalPathient $medicalPathient
     *
     * @return MedicalPathient
     */
    public function register(MedicalPathient $medicalPathient)
    {
        $this->em->persist($medicalPathient);
        $this->em->flush();

        return $medicalPathient;
    }

    /**
     * @param MedicalPathient $medicalPathient
     *
     * @return MedicalPathient
     */
    public function edit(MedicalPathient $medicalPathient)
    {
        $this->em->flush();

        return $medicalPathient;
    }

    /**
     * @param array $attribute
     *
     * @return MedicalPathient
     */
    public function getByAttribute(array $attribute)
    {
        return $this->repository->findOneBy($attribute);
    }
}
