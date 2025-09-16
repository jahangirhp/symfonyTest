<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $model = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $relation = null;

    /**
     * @var Collection<int, Carparts>
     */
    #[ORM\OneToMany(targetEntity: Carparts::class, mappedBy: 'car')]
    private Collection $parts;

    public function __construct()
    {
        $this->parts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getModel(): ?int
    {
        return $this->model;
    }

    public function setModel(int $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @return Collection<int, Carparts>
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(Carparts $part): static
    {
        if (!$this->parts->contains($part)) {
            $this->parts->add($part);
            $part->setCar($this);
        }

        return $this;
    }

    public function removePart(Carparts $part): static
    {
        if ($this->parts->removeElement($part)) {
            // set the owning side to null (unless already changed)
            if ($part->getCar() === $this) {
                $part->setCar(null);
            }
        }

        return $this;
    }
}
