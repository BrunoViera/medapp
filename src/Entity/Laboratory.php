<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LaboratoryRepository")
 * @ORM\Table(name="laboratory", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"})
 */
class Laboratory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="laboratory_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="laboratory_cnmaId", type="bigint", unique=true)
     */
    private $cnmaId;

    /**
     * @ORM\Column(name="laboratory_name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="laboratory_valid", type="boolean")
     */
    private $valid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Medicine", mappedBy="laboratory")
     */
    private $medicines;

    public function __construct()
    {
        $this->medicines = new ArrayCollection();
    }

    /**
     * @return Collection|Medicine[]
     */
    public function getMedicines(): ?Collection
    {
        return $this->medicines;
    }

    public function addMedicine(Medicine $medicine): self
    {
        if (!$this->medicines->contains($medicine)) {
            $this->medicines[] = $medicine;
        }
        return $this;
    }

    public function removeMedicine(Medicine $medicine): self
    {
        if ($this->medicines->contains($medicine)) {
            $this->medicines->removeElement($medicine);
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCnmaId(): ?int
    {
        return $this->cnmaId;
    }

    public function setCnmaId(int $cnmaId): self
    {
        $this->cnmaId = $cnmaId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}
