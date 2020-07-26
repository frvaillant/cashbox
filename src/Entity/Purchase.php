<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $totalAmount;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentMode::class, inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentMode;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseUnity::class, mappedBy="purchase")
     */
    private $purchaseUnities;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="purchases")
     */
    private $event;

    public function __construct()
    {
        $this->purchaseUnities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt = null): self
    {
        if (null === $createdAt) {
            $createdAt = new DateTime('now');
        }
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getPaymentMode(): ?PaymentMode
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(?PaymentMode $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

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
            $purchaseUnity->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseUnity(PurchaseUnity $purchaseUnity): self
    {
        if ($this->purchaseUnities->contains($purchaseUnity)) {
            $this->purchaseUnities->removeElement($purchaseUnity);
            // set the owning side to null (unless already changed)
            if ($purchaseUnity->getPurchase() === $this) {
                $purchaseUnity->setPurchase(null);
            }
        }

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
