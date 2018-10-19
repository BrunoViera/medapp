<?php

namespace App\Service;

use App\Entity\Doctor;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use DateTime;

class DoctorService
{
    const DOCTOR_REGISTER_ACTIVE = 1;
    const DOCTOR_REGISTER_INACTIVE = 0;

    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('App:Doctor');
    }

    /**
     * @return Doctor
     */
    public function create()
    {
        $doc = new Doctor();
        $doc->setIsActive(boolval(self::DOCTOR_REGISTER_INACTIVE));

        return $doc;
    }

    // /**
    //  * @param User $user
    //  *
    //  * @return User
    //  */
    // public function register(User $user)
    // {
    //     $this->em->persist($user);
    //     $this->em->flush();

    //     return $user;
    // }

    // /**
    //  * @param User $user
    //  *
    //  * @return User
    //  */
    // public function edit(User $user)
    // {
    //     $this->em->flush();

    //     return $user;
    // }

    /**
     * @param string $email
     *
     * @return User
     */
    // public function recoverPasswordRequest(string $email)
    // {
    //     $user = $this->repository->findOneBy(['email' => $email, 'isActive' => self::DOCTOR_REGISTER_ACTIVE]);
    //     if ($user instanceof User) {
    //         $user->setPasswordRequest(new Datetime());
    //         $user->setPasswordRequestToken($this->generateToken());

    //         $this->em->flush();
    //     }

    //     return $user;
    // }

    // /**
    //  * @param User $user
    //  *
    //  * @return User
    //  * @throws Exception
    //  */
    // public function recoverPasswordSet(User $user)
    // {
    //     $today = new Datetime();

    //     if ($today->diff($user->getPasswordRequest())->format('%h') > self::MAX_HOURS_PASSWORD_REQUEST) {
    //         throw new Exception(sprintf('Ha superado el número máximo de horas para recuperar la contraseña (%d). Vuelva a solicitarla.', self::MAX_HOURS_PASSWORD_REQUEST));
    //     }

    //     $user->setPasswordRequest(null);
    //     $user->setPasswordRequestToken(null);

    //     $this->em->flush();

    //     return $user;
    // }

    /**
     * @param string $token
     * @return User|object
     */
    // public function getUserByPasswordRequestToken(string $token)
    // {
    //     return $this->repository->findOneBy(['passwordRequestToken' => $token]);
    // }

    // /**
    //  * @param int $length
    //  *
    //  * @return string
    //  */
    // protected function generateToken(int $length = 15)
    // {
    //     return bin2hex(random_bytes($length));
    // }
}
