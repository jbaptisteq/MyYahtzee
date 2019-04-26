<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass="App\Repository\UserRepository")
* @UniqueEntity(fields={"username"}, message="There is already an account with this username")
*/
class User implements UserInterface
{
    /**
    * @ORM\Id()
    * @ORM\GeneratedValue()
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=180, unique=true)
    */
    private $username;

    /**
    * @ORM\Column(type="json")
    */
    private $roles = [];

    /**
    * @var string The hashed password
    * @ORM\Column(type="string")
    */
    private $password;

    /**
    * @ORM\Column(name="email", type="string", length=255)
    * @Assert\NotBlank()
    * @Assert\Email()
    */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
    * A visual identifier that represents this user.
    *
    * @see UserInterface
    */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
    * @see UserInterface
    */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
    * Set email.
    *
    * @param string $email
    *
    *
    */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
    * Get email.
    *
    * @return string
    */
    public function getEmail()
    {
        return $this->email;
    }

    /**
    * @see UserInterface
    */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
    * @see UserInterface
    */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
