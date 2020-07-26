<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startedOn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endedOn;

    /**
     * @ORM\OneToMany(targetEntity=Purchase::class, mappedBy="event")
     */
    private $purchases;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
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

    public function getStartedOn(): ?\DateTimeInterface
    {
        return $this->startedOn;
    }

    public function setStartedOn(?\DateTimeInterface $startedOn): self
    {
        $this->startedOn = $startedOn;

        return $this;
    }

    public function getEndedOn(): ?\DateTimeInterface
    {
        return $this->endedOn;
    }

    public function setEndedOn(?\DateTimeInterface $endedOn): self
    {
        $this->endedOn = $endedOn;

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setEvent($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->contains($purchase)) {
            $this->purchases->removeElement($purchase);
            // set the owning side to null (unless already changed)
            if ($purchase->getEvent() === $this) {
                $purchase->setEvent(null);
            }
        }

        return $this;
    }
}
