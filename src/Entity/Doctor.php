<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 * @ORM\Table(name="doctor", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"})
 * @UniqueEntity(
 *     fields={"email"},
 *     message="El email ya existe en la plataforma"
 * )
 */
class Doctor implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="doctor_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="doctor_salt", type="string", length=32, nullable=false)
     */
    protected $salt;

    /**
     * @ORM\Column(name="doctor_password", type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Debe ingresar un Email", groups={"recover_password_request", "Default"})
     * @Assert\Length(max=127, groups={"recover_password_request", "Default"})
     * @Assert\Email(
     *      groups={"recover_password_request", "Default"},
     *      message = "El email '{{ value }}' no es un email válido."
     * )
     * @ORM\Column(name="doctor_email", type="string", length=127, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="doctor_is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Assert\NotBlank(message="Debe ingresar un Nombre")
     * @Assert\Length(max=127)
     * @ORM\Column(name="doctor_name", type="string", length=127)
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Debe ingresar sus Apellidos")
     * @Assert\Length(max=127)
     * @ORM\Column(name="doctor_last_name", type="string", length=127)
     */
    private $lastName;

    /**
     * @Assert\NotBlank(message="Debe ingresar un Teléfono")
     * @Assert\Length(max=15)
     * @ORM\Column(name="doctor_phone", type="string", length=15)
     */
    private $phone;

    /**
     * @Assert\NotBlank(message="Debe ingresar su Cédula de Identidad")
     * @Assert\Length(max=8)
     * @ORM\Column(name="doctor_personal_id", type="string", length=8)
     */
    private $personalId;

    /**
     * @Assert\NotBlank(message="Debe ingresar un Número de Caja de los Profesionales")
     * @Assert\Length(max=8)
     * @ORM\Column(name="doctor_profesional_input", type="string", length=15)
     */
    private $profesionalInput;

    /**
     * @Assert\DateTime()
     * @ORM\Column(name="doctor_password_requested", type="datetime", nullable=true)
     */
    private $passwordRequest;

    /**
     * @Assert\Length(max=64)
     * @ORM\Column(name="doctor_password_requested_token", type="string", length=64, nullable=true)
     */
    private $passwordRequestToken;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="doctor_created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="doctor_modified_at", type="datetime")
     */
    private $modifiedAt;


    public function __construct()
    {
        $this->salt = substr(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36), 0, 32);
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

    public function getUsername()
    {
        return $this->email;
    }

    public function getRoles() : ? array
    {
        return ['ROLE_SITE_USER', 'ROLE_SITE_DOCTOR'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

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

    public function getSalt()
    {
        return $this->salt;
    }

    public function eraseCredentials()
    {
    }

    public function getName() : ? string
    {
        return $this->name;
    }

    public function setName(? string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName() : ? string
    {
        return $this->lastName;
    }

    public function setLastName(? string $lastName) : self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone() : ? string
    {
        return $this->phone;
    }

    public function setPhone(? string $phone) : self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getpersonalId() : ? integer
    {
        return $this->personalId;
    }

    public function setpersonalId(? integer $personalId) : self
    {
        $this->personalId = $personalId;

        return $this;
    }

    public function getProfesionalInput() : ? string
    {
        return $this->profesionalInput;
    }

    public function setProfesionalInput(? string $profesionalInput) : self
    {
        $this->profesionalInput = $profesionalInput;

        return $this;
    }

    public function getPasswordRequest() : ? \DateTimeInterface
    {
        return $this->passwordRequest;
    }

    public function setPasswordRequest(? \DateTimeInterface $passwordRequest) : self
    {
        $this->passwordRequest = $passwordRequest;

        return $this;
    }

    public function getPasswordRequestToken() : ? string
    {
        return $this->passwordRequestToken;
    }

    public function setPasswordRequestToken(? string $passwordRequestToken) : self
    {
        $this->passwordRequestToken = $passwordRequestToken;

        return $this;
    }
}
