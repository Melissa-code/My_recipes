<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:['username'], message: "Ce nom d'utilisaeur existe déjà.")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5, max:50,
        minMessage: 'Le nom d\'utilisateur doit avoir au minimum 5 caractères',
        maxMessage: 'Le nom d\'utilisateur doit avoir au maximum 50 caractères'
    )]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5, max:50,
        minMessage: 'Le nom d\'utilisateur doit avoir au minimum 5 caractères',
        maxMessage: 'Le nom d\'utilisateur doit avoir au maximum 50 caractères'
    )]
    private ?string $password = null;

    #[Assert\Length(min:5, max:50,
        minMessage: 'Le nom d\'utilisateur doit avoir au minimum 5 caractères',
        maxMessage: 'Le nom d\'utilisateur doit avoir au maximum 50 caractères'
    )]
    #[Assert\EqualTo(propertyPath: "password",
        message: "Les mots de passe ne sont pas équivalents.")]
    private string $checkPassword;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCheckPassword(): string
    {
        return $this->checkPassword;
    }


    public function setCheckPassword(string $checkPassword): self
    {
        $this->checkPassword = $checkPassword;
        return $this;
    }


}
