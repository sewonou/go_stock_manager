<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 65, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Supplier $supplier = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $reference = null;

    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: OrderLine::class)]
    private Collection $orderLines;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $author = null;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
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
        $sum = array_reduce($this->orderLines->toArray(), function ($total, $orderLine){
            return $total + $orderLine->getQte();
        }, 0);
        if(count($this->orderLines) > 0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getTotalAmount()
    {
        $sum = array_reduce($this->orderLines->toArray(), function ($total, $orderLine){
            return $total + ($orderLine->getQte()*$orderLine->getPurchasePrice());
        }, 0);
        if(count($this->orderLines) > 0){
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

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
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
            $orderLine->setPurchase($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getPurchase() === $this) {
                $orderLine->setPurchase(null);
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
