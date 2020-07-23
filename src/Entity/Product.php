<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseUnity::class, mappedBy="product")
     */
    private $purchaseUnities;

    /**
     * @ORM\OneToOne(targetEntity=Stock::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $stock;

    public function __construct()
    {
        $this->purchaseUnities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|PurchaseUnity[]
     */
    public function getPurchaseUnities(): Collection
    {
        return $this->purchaseUnities;
    }

    public function addPurchaseUnity(PurchaseUnity $purchaseUnity): self
    {
        if (!$this->purchaseUnities->contains($purchaseUnity)) {
            $this->purchaseUnities[] = $purchaseUnity;
            $purchaseUnity->setProduct($this);
        }

        return $this;
    }

    public function removePurchaseUnity(PurchaseUnity $purchaseUnity): self
    {
        if ($this->purchaseUnities->contains($purchaseUnity)) {
            $this->purchaseUnities->removeElement($purchaseUnity);
            // set the owning side to null (unless already changed)
            if ($purchaseUnity->getProduct() === $this) {
                $purchaseUnity->setProduct(null);
            }
        }

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        $this->stock = $stock;

        // set the owning side of the relation if necessary
        if ($stock->getProduct() !== $this) {
            $stock->setProduct($this);
        }

        return $this;
    }
}
