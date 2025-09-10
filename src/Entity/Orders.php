<?php

// src/Entity/Order.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Orders
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private int $id;

    #[ORM\Column(type:"string", length:255)]
    private string $title;

    #[ORM\Column(type:"text", nullable:true)]
    private ?string $description = null;

    #[ORM\Column(type:"float")]
    private float $amount;

    #[ORM\Column(type:"string", length:50)]
    private string $status = 'draft';

    #[ORM\Column(type:"datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct() { $this->createdAt = new \DateTime(); }

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function getAmount(): float { return $this->amount; }
    public function setAmount(float $amount): self { $this->amount = $amount; return $this; }
    public function getMarking(): string { return $this->status; }
    public function setMarking(string $status): self { $this->status = $status; return $this; }
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
}
