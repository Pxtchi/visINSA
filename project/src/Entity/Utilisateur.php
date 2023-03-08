<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $mdpUti;


    /**
     * @var string
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var boolean|false
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function setUsername(string $nomUti)
    {
        $this->username = $nomUti;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getmdpUti(): string
    {
        return $this->mdpUti;
    }

    public function setmdpUti(string $mdpUti)
    {
        $this->mdpUti = $mdpUti;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainmdpUti = null;
    }

    public function getPassword(): ?string
    {
       return $this->mdpUti;
    }


    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function generateSignature(string $routeName, int $userId, string $userEmail, array $extraParams = []): VerifyEmailSignatureComponents
    {
        // TODO: Implement generateSignature() method.
    }

    public function validateEmailConfirmation(string $signedUrl, int $userId, string $userEmail): void
    {
        // TODO: Implement validateEmailConfirmation() method.
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }
}
