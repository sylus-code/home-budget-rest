<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="start_date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $frequency;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime", name="due_date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="expiry_date")
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="string", length=255 , name="bank_account_number")
     */
    private $bankAccountNumber;

    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="payment", orphanRemoval=true)
     */
    private $transaction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Receiver", inversedBy="payments")
     */
    private $reciever;

    public function __construct()
    {
        $this->transaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getBankAccountNumber(): ?string
    {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(string $bankAccountNumber): self
    {
        $this->bankAccountNumber = $bankAccountNumber;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transaction->contains($transaction)) {
            $this->transaction[] = $transaction;
            $transaction->setPayment($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transaction->contains($transaction)) {
            $this->transaction->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getPayment() === $this) {
                $transaction->setPayment(null);
            }
        }

        return $this;
    }

    public function getReciever(): ?Receiver
    {
        return $this->reciever;
    }

    public function setReciever(?Receiver $reciever): self
    {
        $this->reciever = $reciever;

        return $this;
    }
}
