<?php

namespace App\Entity;

use App\Repository\OutInventoryLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutInventoryLineRepository::class)]
class OutInventoryLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'outInventoryLines')]
    private ?OutInventory $inventory = null;

    #[ORM\ManyToOne(inversedBy: 'outInventoryLines')]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?int $qte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInventory(): ?OutInventory
    {
        return $this->inventory;
    }

    public function setInventory(?OutInventory $inventory): static
    {
        $this->inventory = $inventory;

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
}
