<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicineRepository")
 * @ORM\Table(name="medicine", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"})
 */
class Medicine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="medicine_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="medicine_type", type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(name="medicine_cnmaId", type="bigint", unique=true)
     */
    private $cnmaId;

    /**
     * @ORM\Column(name="medicine_description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="medicine_name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="medicine_is_valid", type="boolean")
     */
    private $isValid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Laboratory", inversedBy="medicines")
     * @ORM\JoinColumn(name="medicine_laboratory", referencedColumnName="laboratory_id", nullable=false)
     */
    private $laboratory;

    public function __toString()
    {
        return $this->name;
    }

    public function getLaboratory(): ?Laboratory
    {
        return $this->laboratory;
    }

    public function setLaboratory(?Laboratory $laboratory): self
    {
        $this->laboratory = $laboratory;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }
}
