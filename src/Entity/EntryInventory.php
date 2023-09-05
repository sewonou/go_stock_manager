<?php

namespace App\Entity;

use App\Repository\EntryInventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntryInventoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class EntryInventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'entryInventories')]
    private ?User $author = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $reference = null;

    #[ORM\OneToMany(mappedBy: 'inventory', targetEntity: EntryInventoryLine::class)]
    private Collection $entryInventoryLines;

    public function __construct()
    {
        $this->entryInventoryLines = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initialize()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getTotalQte()
    {
        $sum = array_reduce($this->entryInventoryLines->toArray(), function ($total, $entryInventoryLine){
            return $total + $entryInventoryLine->getQte();
        }, 0);
        if(count($this->entryInventoryLines) > 0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getTotalAmount()
    {
        $sum = array_reduce($this->entryInventoryLines->toArray(), function ($total, $entryInventoryLine){
            return $total + ($entryInventoryLine->getQte()*$entryInventoryLine->getProduct()->getSalePrice());
        }, 0);
        if(count($this->entryInventoryLines) > 0){
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

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

    /**
     * @return Collection<int, EntryInventoryLine>
     */
    public function getEntryInventoryLines(): Collection
    {
        return $this->entryInventoryLines;
    }

    public function addEntryInventoryLine(EntryInventoryLine $entryInventoryLine): static
    {
        if (!$this->entryInventoryLines->contains($entryInventoryLine)) {
            $this->entryInventoryLines->add($entryInventoryLine);
            $entryInventoryLine->setInventory($this);
        }

        return $this;
    }

    public function removeEntryInventoryLine(EntryInventoryLine $entryInventoryLine): static
    {
        if ($this->entryInventoryLines->removeElement($entryInventoryLine)) {
            // set the owning side to null (unless already changed)
            if ($entryInventoryLine->getInventory() === $this) {
                $entryInventoryLine->setInventory(null);
            }
        }

        return $this;
    }
}
