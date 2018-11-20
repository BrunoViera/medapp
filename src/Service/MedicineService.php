<?php

namespace App\Service;

use App\Entity\Medicine;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MedicineService
{
    const TYPE_AMPS = 'AMPS';
    const TYPE_AMPPS = 'AMPPS';
    const TYPE_SUSTANCIAS = 'SUSTANCIAS';
    const TYPE_TFS = 'TFS';
    const TYPE_TFGS = 'TFGS';
    const TYPE_VTMS = 'VTMS';
    const TYPE_VMPS = 'VMPS';
    const TYPE_VMPPS = 'VMPPS';

    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:Medicine');
    }

    /**
     * @return Medicine
     */
    public function create()
    {
        return new Medicine();
    }

    public function save(Medicine $medicine)
    {
        $this->em->persist($medicine);

        return $medicine;
    }

    public function flush()
    {
        $this->em->flush();
    }

    /**
     * @param Medicine $medicine
     *
     * @return Medicine
     */
    public function edit(Medicine $medicine)
    {
        $this->em->flush();

        return $medicine;
    }

    /**
     * @param array $attribute
     *
     * @return Medicine
     */
    public function getByAttribute(array $attribute)
    {
        return $this->repository->findOneBy($attribute);
    }
}
