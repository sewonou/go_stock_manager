<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderLineRepository::class)]
class OrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    private ?Order $purchase = null;

    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?int $qte = null;

    #[ORM\Column(nullable: true)]
    private ?int $purchasePrice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Order
    {
        return $this->purchase;
    }

    public function setPurchase(?Order $purchase): static
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(?int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getPurchasePrice(): ?int
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?int $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }
}
