<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: '`product`')]
#[UniqueEntity('sku')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(length: 30, unique: true)]
    private string $sku;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $status;

    #[ORM\Column(type: Types::INTEGER)]
    private int $stock;

    #[ORM\Column(type: Types::FLOAT)]
    private float $price;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $specialPrice;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $specialFrom;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $specialTo;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public \DateTime $lastUpdatedAt;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSpecialPrice(): ?float
    {
        return $this->specialPrice;
    }

    public function setSpecialPrice(float $specialPrice): self
    {
        $this->specialPrice = $specialPrice;

        return $this;
    }

    public function getSpecialFrom(): ?\DateTime
    {
        return $this->specialFrom;
    }

    public function setSpecialFrom(\DateTime $specialFrom): self
    {
        $this->specialFrom = $specialFrom;

        return $this;
    }

    public function getSpecialTo(): ?\DateTime
    {
        return $this->specialTo;
    }

    public function setSpecialTo(\DateTime $specialTo): self
    {
        $this->specialTo = $specialTo;

        return $this;
    }

    public function getLastUpdatedAt(): \DateTime
    {
        return $this->lastUpdatedAt;
    }

    public function setLastUpdatedAt(\DateTime $lastUpdatedAt): self
    {
        $this->lastUpdatedAt = $lastUpdatedAt;

        return $this;
    }
}
