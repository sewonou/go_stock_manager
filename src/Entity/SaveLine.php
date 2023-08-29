<?php

namespace App\Entity;

use App\Repository\SaveLineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as Assert;


class SaveLine
{


    #[Assert\NotBlank(message:"Le code bar du produit  est obligatoire")]
    private ?string $codeBar = null;

    #[Assert\NotBlank(message:"Le produit  est obligatoire")]
    private ?string $product = null;

    #[Assert\NotBlank(message:"La quantité  est obligatoire")]
    private ?int $qte = null;

    private ?int $salePrice = null;

    private ?int $totalAmount = null;

    private ?int $stockQte = null;


    public function getCodeBar(): ?string
    {
        return $this->codeBar;
    }

    public function setCodeBar(?string $codeBar): static
    {
        $this->codeBar = $codeBar;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(?string $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getSalePrice(): ?int
    {
        return $this->salePrice;
    }

    public function setSalePrice(int $salePrice): static
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getTotalAmount(): ?int
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int $totalAmount): static
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function getStockQte(): ?int
    {
        return $this->stockQte;
    }

    public function setStockQte(int $stockQte): static
    {
        $this->stockQte = $stockQte;

        return $this;
    }
}
