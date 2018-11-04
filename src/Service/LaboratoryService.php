<?php

namespace App\Service;

use App\Entity\Laboratory;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class LaboratoryService
{
    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:Laboratory');
    }

    /**
     * @return Laboratory
     */
    public function create()
    {
        return new Laboratory();
    }

    public function save(Laboratory $laboratory)
    {
        $this->em->persist($laboratory);
        $this->em->flush();

        return $laboratory;
    }

    /**
     * @param Laboratory $Laboratory
     *
     * @return Laboratory
     */
    public function edit(Laboratory $laboratory)
    {
        $this->em->flush();
        return $laboratory;
    }

    /**
     * @param array $attribute
     *
     * @return Laboratory
     */
    public function getByAttribute(array $attribute)
    {
        return $this->repository->findOneBy($attribute);
    }
}
