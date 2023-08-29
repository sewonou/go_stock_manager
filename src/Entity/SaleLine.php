<?php

namespace App\Entity;

use App\Repository\SaleLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleLineRepository::class)]
class SaleLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'saleLines')]
    private ?Sale $sale = null;

    #[ORM\ManyToOne(inversedBy: 'qte')]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?int $qte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): static
    {
        $this->sale = $sale;

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
