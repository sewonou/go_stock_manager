<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\Form\remove;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Le nom de produit  est obligatoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "Le nom doit être supérieur à 2 caractères", maxMessage: "Le nom doit être inférieur à 255 caractères")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message:"La description du produit  est obligatoire")]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brandName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Le prix de vente du produit est obligatoire")]
    private ?int $salePrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"L'unité du produit est obligatoire")]
    private ?string $unit = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:"Le quantité seuil  du produit est obligatoire")]
    private ?int $minQte = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:"Le quantité initial disponible en stcok est obligatoire")]
    private ?int $initQte = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Assert\NotBlank(message:"Le code bar du produit est obligatoire")]
    private ?string $codeBar = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Assert\NotBlank(message:"Le categorie (rayonnage) du produit est obligatoire")]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?User $author = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderLine::class)]
    private Collection $orderLines;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: EntryInventoryLine::class)]
    private Collection $entryInventoryLines;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OutInventoryLine::class)]
    private Collection $outInventoryLines;

    public function __construct()
    {
        $this->saleLines = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
        $this->entryInventoryLines = new ArrayCollection();
        $this->outInventoryLines = new ArrayCollection();
    }

    public function getSaleQte()
    {
        $sum = array_reduce($this->saleLines->toArray(), function ($total, $saleLine){
            return $total + ($saleLine->getQte());
        }, 0);
        if(count($this->saleLines)>0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getOutStockQte()
    {
        $sum = array_reduce($this->outInventoryLines->toArray(), function ($total, $outInventoryLine){
            return $total + ($outInventoryLine->getQte());
        }, 0);
        if(count($this->outInventoryLines)>0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getInStockQte()
    {
        $sum = array_reduce($this->entryInventoryLines->toArray(), function ($total, $entryInventoryLine){
            return $total + ($entryInventoryLine->getQte());
        }, 0);
        if(count($this->entryInventoryLines)>0){
            return $sum;
        }else{
            return 0;
        }
    }

    public function getStockQte()
    {
        $sum = $this->initQte + $this->getInStockQte() - $this->getOutStockQte() - $this->getSaleQte();
        return $sum;
    }

    public function getStockValue()
    {
        return $this->getStockQte()*$this->salePrice;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initialize()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTimeImmutable();
        }
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->getName()." Fabriqué par :".$this->getBrandName();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(?string $brandName): static
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getSalePrice(): ?int
    {
        return $this->salePrice;
    }

    public function setSalePrice(?int $salePrice): static
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getMinQte(): ?int
    {
        return $this->minQte;
    }

    public function setMinQte(?int $minQte): static
    {
        $this->minQte = $minQte;

        return $this;
    }

    public function getInitQte(): ?int
    {
        return $this->initQte;
    }

    public function setInitQte(?int $initQte): static
    {
        $this->initQte = $initQte;

        return $this;
    }

    public function getCodeBar(): ?string
    {
        return $this->codeBar;
    }

    public function setCodeBar(?string $codeBar): static
    {
        $this->codeBar = $codeBar;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $saleLine->setProduct($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): static
    {
        if ($this->saleLines->removeElement($saleLine)) {
            // set the owning side to null (unless already changed)
            if ($saleLine->getProduct() === $this) {
                $saleLine->setProduct(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name; // Adjust this based on your entity's properties
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
            $orderLine->setProduct($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getProduct() === $this) {
                $orderLine->setProduct(null);
            }
        }

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
            $entryInventoryLine->setProduct($this);
        }

        return $this;
    }

    public function removeEntryInventoryLine(EntryInventoryLine $entryInventoryLine): static
    {
        if ($this->entryInventoryLines->removeElement($entryInventoryLine)) {
            // set the owning side to null (unless already changed)
            if ($entryInventoryLine->getProduct() === $this) {
                $entryInventoryLine->setProduct(null);
            }
        }

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
            $outInventoryLine->setProduct($this);
        }

        return $this;
    }

    public function removeOutInventoryLine(OutInventoryLine $outInventoryLine): static
    {
        if ($this->outInventoryLines->removeElement($outInventoryLine)) {
            // set the owning side to null (unless already changed)
            if ($outInventoryLine->getProduct() === $this) {
                $outInventoryLine->setProduct(null);
            }
        }

        return $this;
    }

}
