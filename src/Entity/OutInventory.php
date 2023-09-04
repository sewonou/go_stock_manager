<?php

namespace App\Entity;

use App\Repository\OutInventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutInventoryRepository::class)]
class OutInventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'outInventories')]
    private ?User $author = null;

    #[ORM\OneToMany(mappedBy: 'inventory', targetEntity: OutInventoryLine::class)]
    private Collection $outInventoryLines;

    public function __construct()
    {
        $this->outInventoryLines = new ArrayCollection();
    }

    public function getTotalQte()
    {
        $sum = array_reduce($this->outInventoryLines->toArray(), function ($total, $outInventoryLine){
            return $total + $outInventoryLine->getQte();
        }, 0);
        if(count($this->outInventoryLines) > 0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getTotalAmount()
    {
        $sum = array_reduce($this->outInventoryLines->toArray(), function ($total, $outInventoryLine){
            return $total + ($outInventoryLine->getQte()*$outInventoryLine->getProduct()->getSalePrice());
        }, 0);
        if(count($this->outInventoryLines) > 0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

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

    /**
     * @return Collection<int, OutInventoryLine>
     */
    public function getOutInventoryLines(): Collection
    {
        return $this->outInventoryLines;
    }

    public function addOutInventoryLine(OutInventoryLine $outInventoryLine): static
    {
        if (!$this->outInventoryLines->contains($outInventoryLine)) {
            $this->outInventoryLines->add($outInventoryLine);
            $outInventoryLine->setInventory($this);
        }

        return $this;
    }

    public function removeOutInventoryLine(OutInventoryLine $outInventoryLine): static
    {
        if ($this->outInventoryLines->removeElement($outInventoryLine)) {
            // set the owning side to null (unless already changed)
            if ($outInventoryLine->getInventory() === $this) {
                $outInventoryLine->setInventory(null);
            }
        }

        return $this;
    }
}
