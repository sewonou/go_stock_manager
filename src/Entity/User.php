<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
/**
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true, nullable: true)]
    #[Assert\NotBlank(message: "L'identifiant de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 2,max: 50,minMessage: "Le login doit être supérieur à 2 caractères", maxMessage: "Le login doit être inférieur à 50 caractères")]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: "Le mot de passe de l'utilisateur  est obligatoire")]
    private ?string $password = null;

    #[Assert\EqualTo(propertyPath: "password", message: "Vous n'avez pas correctement confirmé votre mot de passe")]
    public $confirmPassword ;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Le nom de l'utilisateur  est obligatoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "Le nom doit être supérieur à 2 caractères", maxMessage: "Le nom doit être inférieur à 255 caractères")]
    private ?string $fullName = null;

    #[Vich\UploadableField(mapping: 'users', fileNameProperty: 'imageName')]
    /**
    * @Ignore()
    */
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message:"Le numéro de téléphone  est obligatoire")]
    #[Assert\Length(min: 2,max: 20,minMessage: "Le numéro doit être supérieur à 2 caractères", maxMessage: "Le numéro doit être inférieur à 20 caractères")]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"L'adresse  est obligatoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "L'adresse doit être supérieur à 2 caractères", maxMessage: "L'adresse doit être inférieur à 255 caractères")]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message:"La description  est obligatoire")]
    #[Assert\Length(min: 2,minMessage: "La description doit être supérieur à 5 mots")]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Assert\NotBlank(message:"Le role de l'utilisateur  est obligatoire")]
    private ?Role $userRole = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Sale::class)]
    private Collection $sales;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: EntryInventory::class)]
    private Collection $entryInventories;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: OutInventory::class)]
    private Collection $outInventories;



    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->sales = new ArrayCollection();
        $this->entryInventories = new ArrayCollection();
        $this->outInventories = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles[] = $this->userRole->getTitle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }



    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
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

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserRole(): ?Role
    {
        return $this->userRole;
    }

    public function setUserRole(?Role $userRole): static
    {
        $this->userRole = $userRole;

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
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setAuthor($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAuthor() === $this) {
                $product->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sale>
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sale $sale): static
    {
        if (!$this->sales->contains($sale)) {
            $this->sales->add($sale);
            $sale->setAuthor($this);
        }

        return $this;
    }

    public function removeSale(Sale $sale): static
    {
        if ($this->sales->removeElement($sale)) {
            // set the owning side to null (unless already changed)
            if ($sale->getAuthor() === $this) {
                $sale->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntryInventory>
     */
    public function getEntryInventories(): Collection
    {
        return $this->entryInventories;
    }

    public function addEntryInventory(EntryInventory $entryInventory): static
    {
        if (!$this->entryInventories->contains($entryInventory)) {
            $this->entryInventories->add($entryInventory);
            $entryInventory->setAuthor($this);
        }

        return $this;
    }

    public function removeEntryInventory(EntryInventory $entryInventory): static
    {
        if ($this->entryInventories->removeElement($entryInventory)) {
            // set the owning side to null (unless already changed)
            if ($entryInventory->getAuthor() === $this) {
                $entryInventory->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OutInventory>
     */
    public function getOutInventories(): Collection
    {
        return $this->outInventories;
    }

    public function addOutInventory(OutInventory $outInventory): static
    {
        if (!$this->outInventories->contains($outInventory)) {
            $this->outInventories->add($outInventory);
            $outInventory->setAuthor($this);
        }

        return $this;
    }

    public function removeOutInventory(OutInventory $outInventory): static
    {
        if ($this->outInventories->removeElement($outInventory)) {
            // set the owning side to null (unless already changed)
            if ($outInventory->getAuthor() === $this) {
                $outInventory->setAuthor(null);
            }
        }

        return $this;
    }


}
