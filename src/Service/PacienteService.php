<?php

namespace App\Service;

use App\Entity\Paciente;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use DateTime;

class PacienteService
{
    const PACIENTE_GENDER_DESCONOCIDO = 'Desconocido';
    const PACIENTE_GENDER_NO_APLICA = 'No Aplica';
    const PACIENTE_GENDER_MASCULINO = 'Masculino';
    const PACIENTE_GENDER_FEMENINO = 'Femenino';

    const PACIENTE_REGISTER_ACTIVE = 1;
    const PACIENTE_REGISTER_INACTIVE = 0;


    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:Paciente');
    }

    /**
     *
     */
    public function getGenderList()
    {
        return [
            self::PACIENTE_GENDER_FEMENINO => 1,
            self::PACIENTE_GENDER_NO_APLICA => 2,
            self::PACIENTE_GENDER_MASCULINO => 3,
            self::PACIENTE_GENDER_DESCONOCIDO => 4,
        ];
    }

    /**
     * @return Paciente
     */
    public function create()
    {
        $paciente = new Paciente();
        $paciente->setIsActive(boolval(self::PACIENTE_REGISTER_INACTIVE));

        return $paciente;
    }

    /**
     * @param Paciente $paciente
     *
     * @return Paciente
     */
    public function register(Paciente $paciente)
    {
        $this->em->persist($paciente);
        $this->em->flush();

        return $paciente;
    }

    /**
     * @param Paciente $paciente
     *
     * @return Paciente
     */
    public function edit(Paciente $paciente)
    {
        $this->em->flush();

        return $paciente;
    }
}
