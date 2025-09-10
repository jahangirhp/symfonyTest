<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  public  function __construct()
    {
        $this->roles = [];
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

        #[ORM\Column]
    private ?string $name = null;

        #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];



    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles ?? [];
        $roles[] = 'ROLE_USER'; // default role
        return array_unique($roles);
    }



    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getPassword(): ?string
    {
        return $this->password;
        // TODO: Implement getPassword() method.
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles ?? [])) {
            $this->roles[] = $role;
        }
        return $this;
    }


}
