<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Le nom du fournisseur  est obligatoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "Le nom doit être supérieur à 2 caractères", maxMessage: "Le nom doit être inférieur à 255 caractères")]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Le nom de la personne contact est obligatoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "Le nom doit être supérieur à 2 caractères", maxMessage: "Le nom doit être inférieur à 255 caractères")]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"L'adresse email est obligatoire  est obligatoire")]
    #[Assert\Email(message: "{{ value }} n'est pas une adresse email valide")]
    private ?string $email = null;

    #[ORM\Column(length: 25)]
    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire")]
    #[Assert\Length(min: 2,max: 255, minMessage: "Le numéro doit être supérieur à 2 caractères", maxMessage: "Le numéro doit être inférieur à 25 caractères")]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'supplier', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initialize()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setSupplier($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getSupplier() === $this) {
                $order->setSupplier(null);
            }
        }

        return $this;
    }
}
