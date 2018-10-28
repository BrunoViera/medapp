<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PacienteRepository")
 * @ORM\Table(name="paciente", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"})
 * @UniqueEntity(
 *     fields={"personalId"},
 *     message="La cédula de indentidad ingresada ya existe en la plataforma"
 * )
 */
class Paciente
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="paciente_id", type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Debe ingresar un número de Cédula")
     * @ORM\Column(name="paciente_personal_id", type="string", length=13, unique=true)
     */
    private $personalId;

    /**
     * @Assert\NotBlank(message="Debe ingresar un nombre")
     * @Assert\Length(max=64)
     * @ORM\Column(name="paciente_name", type="string", length=64, nullable=false)
     */
    protected $name;

    /**
     * @Assert\NotBlank(message="Debe ingresar un apellido")
     * @Assert\Length(max=64)
     * @ORM\Column(name="paciente_last_name", type="string", length=64, nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(name="paciente_is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Assert\NotBlank(message="Debe ingresar sus género")
     * @ORM\Column(name="paciente_gender", type="string", length=127, nullable=false)
     */
    private $gender;

    /**
     * @Assert\DateTime()
     * @ORM\Column(name="paciente_birthday", type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @Assert\NotBlank(message="Debe ingresar el peso del paciente")
     * @ORM\Column(name="paciente_weight", type="integer", nullable=false)
     */
    private $weight;

    /**
     * @Assert\NotBlank(message="Debe ingresar la altura del paciente")
     * @ORM\Column(name="paciente_height", type="integer", nullable=false)
     */
    private $height;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="paciente_created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="paciente_modified_at", type="datetime")
     */
    private $modifiedAt;


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
}
