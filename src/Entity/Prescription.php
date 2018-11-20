<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrescriptionRepository")
 * @ORM\Table(name="prescription", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"})
 */
class Prescription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="prescription_id", type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor")
     * @ORM\JoinColumn(name="prescription_doctor", referencedColumnName="doctor_id", nullable=false)
     */
    private $doctor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicine")
     * @ORM\JoinColumn(name="prescription_medicine", referencedColumnName="medicine_id", nullable=false)
     */
    private $medicine;

    /**
     * @ORM\Column(name="prescription_class", type="string", length=255)
     */
    private $class;

    /**
     * @ORM\Column(name="prescription_frequency", type="string", length=255)
     */
    private $frequency;

    /**
     * @ORM\Column(name="prescription_dose", type="string", length=255)
     */
    private $dose;

    /**
     * @ORM\Column(name="prescription_description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="prescription_start_at", type="datetime", nullable=true)
     */
    private $startAt;

    /**
     * @ORM\Column(name="prescription_ends_at", type="datetime", nullable=true)
     */
    private $endsAt;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="prescription_created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MedicalPathient", inversedBy="prescriptions")
     * @ORM\JoinColumn(name="prescription_medical_pathient", referencedColumnName="medical_pathient_id", nullable=false)
     */
    private $medicalPatient;

    /**
     * @ORM\Column(name="prescription_active", type="boolean", nullable=false)
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getMedicine(): ?Medicine
    {
        return $this->medicine;
    }

    public function setMedicine(?Medicine $medicine): self
    {
        $this->medicine = $medicine;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose(string $dose): self
    {
        $this->dose = $dose;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(?\DateTimeInterface $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMedicalPatient(): ?MedicalPathient
    {
        return $this->medicalPatient;
    }

    public function setMedicalPatient(?MedicalPathient $medicalPatient): self
    {
        $this->medicalPatient = $medicalPatient;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
