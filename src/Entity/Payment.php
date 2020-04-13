<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="start_date")
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $frequency;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $amount;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer", name="due_day", nullable=true)
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $dueDay;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $note;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="expiry_date", nullable=true)
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="string", length=255 , name="bank_account_number", nullable=true)
     * @Groups({"transaction_get_list", "payment_get_list", "receiver_get_list"})
     */
    private $bankAccountNumber;

    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="payment", orphanRemoval=true)
     * @Groups("payment_get_list")
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Receiver", inversedBy="payments")
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $reciever;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
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

    public function getDueDay(): ?\DateTimeInterface
    {
        return $this->dueDay;
    }

    public function setDueDay(\DateTimeInterface $dueDay): self
    {
        $this->dueDay = $dueDay;

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
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setPayment($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
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
