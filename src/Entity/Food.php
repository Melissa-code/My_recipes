<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min:3, max:50, minMessage: 'Le nom doit avoir au minimum 3 caractères', maxMessage: 'Le nom doit avoir au maximum 50 caractères')]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage: 'Le prix doit être compris entre {{ min }} € et {{ max }} €', min: 0.1, max: 200,)]
    #[Assert\NotNull]
    private ?float $price = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(min:3, max:100, minMessage: 'L\image doit avoir au minimum 3 caractères', maxMessage: 'L\image doit avoir au maximum 100 caractères')]
    #[Assert\NotBlank]
    private ?string $image = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage: 'Les calories doivent être comprises entre {{ min }} et {{ max }}', min: 0.1, max: 180,)]
    #[Assert\NotNull]
    private ?int $calorie = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage:'Les protéines doivent être comprises entre {{ min }} et {{ max }}', min: 0.1, max: 180,)]
    #[Assert\NotNull]
    private ?float $protein = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage: 'Les glucides doivent être compris entre {{ min }} et {{ max }}', min: 0.1, max: 180,)]
    #[Assert\NotNull]
    private ?float $carbohydrate = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage: 'Les lipides doivent être compris entre {{ min }} et {{ max }}', min: 0.1, max: 180,)]
    #[Assert\NotNull]
    private ?float $lipid = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    public function setCalorie(int $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getCarbohydrate(): ?float
    {
        return $this->carbohydrate;
    }

    public function setCarbohydrate(float $carbohydrate): self
    {
        $this->carbohydrate = $carbohydrate;

        return $this;
    }

    public function getLipid(): ?float
    {
        return $this->lipid;
    }

    public function setLipid(float $lipid): self
    {
        $this->lipid = $lipid;

        return $this;
    }
}
