<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(nullable: true)]
    private ?int $code=null ;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2,nullable: true)]
    private ?string $price = '0.00';

     #[ORM\Column(nullable: true)]
    private ?string $imgUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static

    {
                $this->description = $description;

                return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }
}
