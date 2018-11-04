<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicalPathientRepository")
 * @ORM\Table(name="medical_pathient", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"})
 * @UniqueEntity(
 *     fields={"personalId"},
 *     message="La cédula de indentidad ingresada ya existe en la plataforma"
 * )
 */
class MedicalPathient
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="medical_pathient_id", type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Debe ingresar un número de Cédula")
     * @ORM\Column(name="medical_pathient_personal_id", type="string", length=13, unique=true)
     */
    private $personalId;

    /**
     * @Assert\NotBlank(message="Debe ingresar un nombre")
     * @Assert\Length(max=64)
     * @ORM\Column(name="medical_pathient_name", type="string", length=64, nullable=false)
     */
    protected $name;

    /**
     * @Assert\NotBlank(message="Debe ingresar un apellido")
     * @Assert\Length(max=64)
     * @ORM\Column(name="medical_pathient_last_name", type="string", length=64, nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(name="medical_pathient_is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Assert\NotBlank(message="Debe ingresar sus género")
     * @ORM\Column(name="medical_pathient_gender", type="string", length=127, nullable=false)
     */
    private $gender;

    /**
     * @Assert\DateTime()
     * @ORM\Column(name="medical_pathient_birthday", type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @Assert\NotBlank(message="Debe ingresar el peso del MedicalPathient")
     * @ORM\Column(name="medical_pathient_weight", type="integer", nullable=false)
     */
    private $weight;

    /**
     * @Assert\NotBlank(message="Debe ingresar la altura del MedicalPathient")
     * @ORM\Column(name="medical_pathient_height", type="integer", nullable=false)
     */
    private $height;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="medical_pathient_created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="medical_pathient_modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prescription", mappedBy="medicalPatient", orphanRemoval=true)
     * @ ORM\JoinColumn(name="medical_pathient_prescriptions", referencedColumnName="prescription_id", nullable=true)
     */
    private $prescriptions;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name . '' . $this->lastName;
    }

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt() : ? \DateTimeInterface
    {
        return $this->modifiedAt;
    }
    public function setModifiedAt(\DateTimeInterface $modifiedAt) : self
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPersonalId() : ? string
    {
        return $this->personalId;
    }

    public function setPersonalId(string $personalId) : self
    {
        $this->personalId = $personalId;
        return $this;
    }

    public function getName() : ? string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function getLastName() : ? string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName) : self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getIsActive() : bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive) : self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getGender() : ? string
    {
        return $this->gender;
    }

    public function setGender(string $gender) : self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthday() : ? \DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday = null) : self
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getWeight() : ? int
    {
        return $this->weight;
    }

    public function setWeight(int $weight) : self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getHeight() : ? int
    {
        return $this->height;
    }

    public function setHeight(int $height) : self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return Collection|Prescription[]
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): self
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions[] = $prescription;
            $prescription->setMedicalPatient($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): self
    {
        if ($this->prescriptions->contains($prescription)) {
            $this->prescriptions->removeElement($prescription);
            // set the owning side to null (unless already changed)
            if ($prescription->getMedicalPatient() === $this) {
                $prescription->setMedicalPatient(null);
            }
        }

        return $this;
    }
}
