<?php

namespace App\Service;

use App\Entity\Medicine;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MedicineService
{
    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:Medicine');
    }

    public function save(Medicine $medicine)
    {
        $this->em->persist($medicine);
        $this->em->flush();

        return $medicine;
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
}
