<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $saleAt = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clientName = null;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    private ?User $author = null;

    public function __construct()
    {
        $this->saleLines = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initialize()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTimeImmutable();
            $this->saleAt = new \DateTimeImmutable();
        }
        $this->updatedAt = new  \DateTimeImmutable();
    }

    public function getAmount()
    {
        $sum = array_reduce($this->saleLines->toArray(), function ($total, $saleLine){
            return $total + ($saleLine->getQte()* $saleLine->getProduct()->getSalePrice());
        }, 0);
        if(count($this->saleLines) > 0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getSaleAt(): ?\DateTimeImmutable
    {
        return $this->saleAt;
    }

    public function setSaleAt(?\DateTimeImmutable $saleAt): static
    {
        $this->saleAt = $saleAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(?string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * @return Collection<int, SaleLine>
     */
    public function getSaleLines(): Collection
    {
        return $this->saleLines;
    }

    public function addSaleLine(SaleLine $saleLine): static
    {
        if (!$this->saleLines->contains($saleLine)) {
            $this->saleLines->add($saleLine);
            $saleLine->setSale($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): static
    {
        if ($this->saleLines->removeElement($saleLine)) {
            // set the owning side to null (unless already changed)
            if ($saleLine->getSale() === $this) {
                $saleLine->setSale(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
